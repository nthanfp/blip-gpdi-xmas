<?php

class Voucher_Model extends CI_Model
{
    /*
    Status =
    1 = Active
    2 = Printed
    3 = Redeemed
    4 = Completed
    5 = Rejected
    */
    private $_table = 'mst_voucher';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Global_Model');
        $this->load->helper('global');
    }

    private function current_user_id()
    {
        $CI = &get_instance();

        if (!isset($CI->Auth_Model)) {
            $CI->load->model('Auth_Model');
        }

        $current_user = $CI->Auth_Model->current_user();

        return $current_user ? $current_user : null;
    }

    private function normalize_itemgiftid($mst_itemgiftid)
    {
        if ($mst_itemgiftid === '' || $mst_itemgiftid === null || is_array($mst_itemgiftid)) {
            return null;
        }

        $mst_itemgiftid = trim((string) $mst_itemgiftid);

        if ($mst_itemgiftid === '' || !ctype_digit($mst_itemgiftid)) {
            return null;
        }

        return (int) $mst_itemgiftid;
    }

    private function normalize_status($status, $default = 1)
    {
        if ($status === '' || $status === null || is_array($status)) {
            return $default === null ? null : (int) $default;
        }

        $status = trim((string) $status);

        if ($status === '') {
            return $default === null ? null : (int) $default;
        }

        if (!ctype_digit($status)) {
            return null;
        }

        $status = (int) $status;

        if (!in_array($status, [1, 2, 3, 4, 5], true)) {
            return null;
        }

        return $status;
    }

    private function normalize_date($value)
    {
        if ($value === '' || $value === null || is_array($value)) {
            return null;
        }

        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return $value . ' 23:59:59';
        }

        return $value;
    }

    private function build_voucher_key($voucher_code)
    {
        $secret = getenv('VOUCHER_HMAC_SECRET') ?: 'IT_INTERNAL_2026';

        return hash_hmac(
            'sha256',
            trim((string) $voucher_code),
            $secret
        );
    }

    private function normalize_bulk_prefix($prefix)
    {
        $prefix = trim((string) $prefix);
        if ($prefix === '') {
            return '';
        }

        $prefix = strtoupper($prefix);
        $prefix = preg_replace('/[^A-Z0-9]+/', '', $prefix);

        return $prefix;
    }

    private function generate_unique_voucher_code($prefix, $mst_itemgiftid, $index, $itemtype = 1)
    {
        $custom_prefix = $this->normalize_bulk_prefix($prefix);
        $item_suffix = str_pad((string) ((int) $mst_itemgiftid % 10000), 3, '0', STR_PAD_LEFT);
        $day_stamp = date('ymd');

        for ($attempt = 0; $attempt < 10; $attempt++) {
            $random = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
            $code_parts = [];

            if ((int) $itemtype === 2) {
                $code_parts[] = 'SHP';
            }

            if ($custom_prefix !== '') {
                $code_parts[] = $custom_prefix;
            }

            $code_parts[] = $day_stamp;
            $code_parts[] = $item_suffix;
            $code_parts[] = $random;

            $voucher_code = implode('-', $code_parts);

            $exists = $this->db->where('voucher_code', $voucher_code)
                ->count_all_results($this->_table) > 0;

            if (!$exists) {
                return $voucher_code;
            }
        }

        return null;
    }

    private function itemgift_exists($mst_itemgiftid)
    {
        if ($mst_itemgiftid === null) {
            return false;
        }

        return $this->db->where('mst_itemgiftid', (int) $mst_itemgiftid)
            ->where('suspended', 0)
            ->count_all_results('mst_itemgift') > 0;
    }

    private function get_itemgift_itemtype($mst_itemgiftid)
    {
        if ($mst_itemgiftid === null) {
            return null;
        }

        $row = $this->db->select('itemtype')
            ->where('mst_itemgiftid', (int) $mst_itemgiftid)
            ->where('suspended', 0)
            ->get('mst_itemgift')
            ->row();

        return $row ? (int) $row->itemtype : null;
    }

    private function customer_exists($mst_customerid)
    {
        if ($mst_customerid === null) {
            return false;
        }

        return $this->db->select('mst_customerid, custname, phone_number, email')
            ->from('mst_customer')
            ->where('mst_customerid', (int) $mst_customerid)
            ->get()
            ->row();
    }

    private function normalize_nullable_float($value)
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        return is_numeric($value) ? (float) $value : null;
    }

    private function compress_image_to_jpeg($source_path, $dest_path, $max_size_bytes = 1048576)
    {
        $image_info = @getimagesize($source_path);
        if ($image_info === false) {
            return false;
        }

        $mime = $image_info['mime'];
        $width = $image_info[0];
        $height = $image_info[1];

        switch ($mime) {
            case 'image/jpeg':
                $src_image = @imagecreatefromjpeg($source_path);
                break;
            case 'image/png':
                $src_image = @imagecreatefrompng($source_path);
                break;
            case 'image/gif':
                $src_image = @imagecreatefromgif($source_path);
                break;
            case 'image/webp':
                $src_image = @imagecreatefromwebp($source_path);
                break;
            default:
                return false;
        }

        if (!$src_image) {
            return false;
        }

        $max_dimension = 1920;
        if ($width > $max_dimension || $height > $max_dimension) {
            if ($width > $height) {
                $height = (int)(($height / $width) * $max_dimension);
                $width = $max_dimension;
            } else {
                $width = (int)(($width / $height) * $max_dimension);
                $height = $max_dimension;
            }
        }

        $dst_image = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($dst_image, 255, 255, 255);
        imagefill($dst_image, 0, 0, $white);
        imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $width, $height, $image_info[0], $image_info[1]);
        imagedestroy($src_image);

        $quality = 85;
        $compressed = false;

        while ($quality >= 30) {
            @imagejpeg($dst_image, $dest_path, $quality);
            if (file_exists($dest_path) && filesize($dest_path) <= $max_size_bytes) {
                $compressed = true;
                break;
            }
            $quality -= 5;
        }

        if (!$compressed && file_exists($dest_path)) {
            @imagejpeg($dst_image, $dest_path, $quality);
        }

        imagedestroy($dst_image);

        return file_exists($dest_path) && filesize($dest_path) <= $max_size_bytes;
    }

    private function validate_and_upload_proof($file, &$uploaded_path)
    {
        if (empty($file) || !isset($file['tmp_name'])) {
            return ['success' => false, 'message' => 'No file was uploaded'];
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $error_map = [
                UPLOAD_ERR_INI_SIZE => 'File exceeds the maximum allowed size',
                UPLOAD_ERR_FORM_SIZE => 'File exceeds the maximum allowed size',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload',
            ];
            $msg = isset($error_map[$file['error']]) ? $error_map[$file['error']] : 'Unknown upload error';
            return ['success' => false, 'message' => $msg];
        }

        $upload_dir = FCPATH . 'uploads/purchase-proof/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0755, true);
        }

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $max_file_size = 5 * 1024 * 1024;
        $compress_threshold = 1 * 1024 * 1024;

        if ($file['size'] > $max_file_size) {
            return ['success' => false, 'message' => 'File size exceeds 5MB limit'];
        }

        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_extensions, true)) {
            return ['success' => false, 'message' => 'File type is not allowed. Allowed: JPG, PNG, GIF, WEBP'];
        }

        $detected_type = @mime_content_type($file['tmp_name']);
        if (!in_array($detected_type, $allowed_types, true)) {
            return ['success' => false, 'message' => 'Invalid file content. Only image files are allowed'];
        }

        $image_info = @getimagesize($file['tmp_name']);
        if ($image_info === false) {
            return ['success' => false, 'message' => 'File is not a valid image'];
        }

        $exif_imagetype = @exif_imagetype($file['tmp_name']);
        if ($exif_imagetype === false) {
            return ['success' => false, 'message' => 'File is not a valid image format'];
        }

        $needs_compression = $file['size'] > $compress_threshold;
        $safe_name = 'proof_' . bin2hex(random_bytes(16)) . ($needs_compression ? '.jpg' : '.' . $file_ext);
        $dest_path = $upload_dir . $safe_name;

        if ($needs_compression) {
            $compressed = $this->compress_image_to_jpeg($file['tmp_name'], $dest_path, $compress_threshold);
            if (!$compressed) {
                return ['success' => false, 'message' => 'Failed to compress image. Please upload a smaller file.'];
            }
        } else {
            if (!@move_uploaded_file($file['tmp_name'], $dest_path)) {
                return ['success' => false, 'message' => 'Failed to save uploaded file'];
            }
        }

        @chmod($dest_path, 0644);

        $uploaded_path = 'uploads/purchase-proof/' . $safe_name;

        return ['success' => true];
    }

    public function rules($mode = 'create')
    {
        return [
            [
                'field' => 'mst_itemgiftid',
                'label' => 'Item Gift',
                'rules' => 'required|numeric'
            ],
            [
                'field' => 'voucher_code',
                'label' => 'Voucher Code',
                'rules' => 'required|max_length[100]'
            ],
            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'in_list[1,2,3,4,5]'
            ],
            [
                'field' => 'expired_date',
                'label' => 'Expired Date',
                'rules' => 'max_length[30]'
            ],
            [
                'field' => 'redeemed_date',
                'label' => 'Redeemed Date',
                'rules' => 'max_length[30]'
            ]
        ];
    }

    private function _apply_status_filter($status)
    {
        $status = trim((string) $status);
        if ($status === '') {
            return;
        }

        $now = date('Y-m-d H:i:s');

        switch ($status) {
            case 'available':
                $this->db->where('v.status', 1);
                $this->db->group_start()
                    ->where('v.expired_date IS NULL', null, false)
                    ->or_where('v.expired_date >=', $now)
                    ->group_end();
                break;
            case 'printed':
                $this->db->where('v.status', 2);
                $this->db->group_start()
                    ->where('v.expired_date IS NULL', null, false)
                    ->or_where('v.expired_date >=', $now)
                    ->group_end();
                break;
            case 'redeemed':
                $this->db->where('v.status', 3);
                break;
            case 'completed':
                $this->db->where('v.status', 4);
                break;
            case 'rejected':
                $this->db->where('v.status', 5);
                break;
            case 'expired':
                $this->db->where('v.status', 1);
                $this->db->where('v.expired_date IS NOT NULL', null, false);
                $this->db->where('v.expired_date <', $now);
                break;
            default:
                $numeric = $this->normalize_status($status, null);
                if ($numeric !== null) {
                    $this->db->where('v.status', $numeric);
                }
                break;
        }
    }

    public function data_list($page = 1, $per_page = 10, $search = '', $mst_itemgiftid = '', $itemgift_type = '', $status = '', $sort_by = 'created_date', $sort_dir = 'DESC', $bulk_code = '', $bulk_seq = '')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table . ' v');
        $this->db->select('v.*, g.itemname, g.itemtype');
        $this->db->join('mst_itemgift g', 'g.mst_itemgiftid = v.mst_itemgiftid', 'left');

        if ($search !== '') {
            $s = $this->db->escape('%' . $search . '%');
            $this->db->group_start()
                ->where("CAST(v.mst_voucherid AS TEXT) LIKE $s")
                ->or_like('v.voucher_code', $search)
                ->or_like('g.itemname', $search)
                ->group_end();
        }

        $mst_itemgiftid = $this->normalize_itemgiftid($mst_itemgiftid);
        if ($mst_itemgiftid !== null) {
            $this->db->where('v.mst_itemgiftid', $mst_itemgiftid);
        }

        if ($itemgift_type !== '') {
            $this->db->where('g.itemtype', (int) $itemgift_type);
        }

        $this->_apply_status_filter($status);

        if ($bulk_code !== '') {
            $this->db->where('v.bulk_code', $bulk_code);
        }

        if ($bulk_seq !== '') {
            $this->db->where('v.bulk_seq', (int) $bulk_seq);
        }

        $total = $this->db->count_all_results('', false);

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir));

        $allowed_sort_columns = [
            'mst_voucherid' => 'v.mst_voucherid',
            'voucher_code' => 'v.voucher_code',
            'itemname' => 'g.itemname',
            'status' => 'v.status',
            'expired_date' => 'v.expired_date',
            'redeemed_date' => 'v.redeemed_date'
        ];

        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'v.mst_voucherid';
        $sort_dir = $sort_dir === 'asc' ? 'ASC' : 'DESC';

        $this->db->order_by($sort_column, $sort_dir);
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Voucher data retrieved successfully',
            'data' => $rows,
            'pagination' => [
                'page' => $page,
                'per_page' => $per_page,
                'total' => (int) $total,
                'total_pages' => (int) ceil($total / $per_page),
                'has_prev' => $page > 1,
                'has_next' => ($page * $per_page) < $total
            ]
        ];
    }

    public function data_list_print($search = '', $mst_itemgiftid = '', $itemgift_type = '', $status = '', $sort_by = 'created_date', $sort_dir = 'DESC', $bulk_code = '', $bulk_seq = '')
    {
        $this->db->from($this->_table . ' v');
        $this->db->select('v.*, g.itemname, g.itemtype');
        $this->db->join('mst_itemgift g', 'g.mst_itemgiftid = v.mst_itemgiftid', 'left');

        if ($search !== '') {
            $s = $this->db->escape('%' . $search . '%');
            $this->db->group_start()
                ->where("CAST(v.mst_voucherid AS TEXT) LIKE $s")
                ->or_like('v.voucher_code', $search)
                ->or_like('g.itemname', $search)
                ->group_end();
        }

        $mst_itemgiftid = $this->normalize_itemgiftid($mst_itemgiftid);
        if ($mst_itemgiftid !== null) {
            $this->db->where('v.mst_itemgiftid', $mst_itemgiftid);
        }

        if ($itemgift_type !== '') {
            $this->db->where('g.itemtype', (int) $itemgift_type);
        }

        $this->_apply_status_filter($status);

        if ($bulk_code !== '') {
            $this->db->where('v.bulk_code', $bulk_code);
        }

        if ($bulk_seq !== '') {
            $this->db->where('v.bulk_seq', (int) $bulk_seq);
        }

        $sort_by = trim((string) $sort_by);
        $sort_dir = strtolower(trim((string) $sort_dir));

        $allowed_sort_columns = [
            'mst_voucherid' => 'v.mst_voucherid',
            'voucher_code' => 'v.voucher_code',
            'itemname' => 'g.itemname',
            'status' => 'v.status',
            'expired_date' => 'v.expired_date',
            'redeemed_date' => 'v.redeemed_date'
        ];

        $sort_column = isset($allowed_sort_columns[$sort_by]) ? $allowed_sort_columns[$sort_by] : 'v.mst_voucherid';
        $sort_dir = $sort_dir === 'asc' ? 'ASC' : 'DESC';

        $this->db->order_by($sort_column, $sort_dir);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Voucher data retrieved successfully',
            'data' => $rows
        ];
    }

    public function data_option_bulk_code()
    {
        $rows = $this->db->select('bulk_code, MAX(created_date) as max_created')
            ->from($this->_table)
            ->where('bulk_code IS NOT NULL', null, false)
            ->where('bulk_code !=', '')
            ->group_by('bulk_code')
            ->order_by('max_created', 'DESC')
            ->get()
            ->result();

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'bulk_code' => $row->bulk_code
            ];
        }

        return [
            'success' => true,
            'message' => 'Bulk code options retrieved successfully',
            'data' => $data
        ];
    }

    public function data_option_itemgift()
    {
        $rows = $this->db->select('mst_itemgiftid, itemname, itemtype, value')
            ->from('mst_itemgift')
            ->where('suspended', 0)
            ->order_by("
                CASE
                    WHEN itemname LIKE 'E-WALLET%' THEN 0
                    ELSE 1
                END
            ", "", false)
            ->order_by('value', 'ASC')
            ->order_by('itemname', 'ASC')
            ->get()
            ->result();

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'mst_itemgiftid' => $row->mst_itemgiftid,
                'itemname' => $row->itemname,
                'itemtype' => $row->itemtype,
                'display_name' => $row->itemname
            ];
        }

        return [
            'success' => true,
            'message' => 'Item gift options retrieved successfully',
            'data' => $data
        ];
    }

    public function data_new(array $input)
    {
        $mst_itemgiftid = $this->normalize_itemgiftid($input['mst_itemgiftid'] ?? null);
        $voucher_code = trim((string) ($input['voucher_code'] ?? ''));
        $status = $this->normalize_status($input['status'] ?? null, 1);
        $expired_date = $this->normalize_date($input['expired_date'] ?? null);
        $redeemed_date = $this->normalize_date($input['redeemed_date'] ?? null);
        $current_user = $this->current_user_id()->username;
        $mst_voucherid = $this->Global_Model->get_autoid_seq('seq_mst_voucher');

        if ($mst_voucherid === null) {
            return [
                'success' => false,
                'message' => 'Failed to generate voucher ID'
            ];
        }

        if ($mst_itemgiftid === null) {
            return [
                'success' => false,
                'message' => 'Item gift is required'
            ];
        }

        if (!$this->itemgift_exists($mst_itemgiftid)) {
            return [
                'success' => false,
                'message' => 'Item gift data not found'
            ];
        }

        $this->db->where('voucher_code', $voucher_code);
        if ($this->db->count_all_results($this->_table) > 0) {
            return [
                'success' => false,
                'message' => 'Voucher code is already in use'
            ];
        }

        if ($expired_date !== null && $expired_date <= date('Y-m-d 23:59:59')) {
            return [
                'success' => false,
                'message' => 'Expired date must be greater than today'
            ];
        }

        if ($status === null) {
            $status = 1;
        }

        $data = [
            'mst_voucherid' => $mst_voucherid,
            'mst_itemgiftid' => $mst_itemgiftid,
            'voucher_code' => $voucher_code,
            'voucher_key' => $this->build_voucher_key($voucher_code),
            'status' => $status,
            'expired_date' => $expired_date,
            'redeemed_date' => $redeemed_date,
            'created_by' => $current_user,
            'created_date' => date('Y-m-d H:i:s')
        ];

        $insert = $this->db->insert($this->_table, $data);

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'Voucher data created successfully' : 'Failed to create voucher data'
        ];
    }

    public function data_bulk_new(array $input)
    {
        /*
        Jika mst_itemgift.itemtype === 2 (E-Wallet) yang diminta untuk buat voucher
        Beri prefix SHP- baru prefix custom dan seterusnya
        */
        $bulk_prefix = $this->normalize_bulk_prefix($input['bulk_prefix'] ?? '');
        $status = $this->normalize_status($input['status'] ?? null, 1);
        $expired_date = $this->normalize_date($input['expired_date'] ?? null);
        $items = isset($input['items']) && is_array($input['items']) ? $input['items'] : [];
        $current_user = $this->current_user_id()->username;
        $created_rows = [];

        if ($status === null) {
            return [
                'success' => false,
                'message' => 'Invalid voucher status'
            ];
        }

        if (empty($items)) {
            return [
                'success' => false,
                'message' => 'Bulk item list is required'
            ];
        }

        $bulk_code = strtoupper(bin2hex(random_bytes(16)));
        $bulk_seq = 0;

        $this->db->trans_begin();

        foreach ($items as $index => $item_input) {
            $mst_itemgiftid = $this->normalize_itemgiftid($item_input['mst_itemgiftid'] ?? null);
            $qty = isset($item_input['qty']) ? (int) $item_input['qty'] : 0;

            if ($mst_itemgiftid === null) {
                $this->db->trans_rollback();
                return [
                    'success' => false,
                    'message' => 'Item gift is required for each bulk row'
                ];
            }

            if (!$this->itemgift_exists($mst_itemgiftid)) {
                $this->db->trans_rollback();
                return [
                    'success' => false,
                    'message' => 'Item gift data not found'
                ];
            }

            $itemtype = $this->get_itemgift_itemtype($mst_itemgiftid);

            if ($qty < 1) {
                $this->db->trans_rollback();
                return [
                    'success' => false,
                    'message' => 'Quantity must be at least 1'
                ];
            }

            if ($qty > 100000) {
                $this->db->trans_rollback();
                return [
                    'success' => false,
                    'message' => 'Maximum quantity per item is 100000'
                ];
            }

            for ($row = 1; $row <= $qty; $row++) {
                $bulk_seq++;

                $mst_voucherid = $this->Global_Model->get_autoid_seq('seq_mst_voucher');

                if ($mst_voucherid === null) {
                    $this->db->trans_rollback();
                    return [
                        'success' => false,
                        'message' => 'Failed to generate voucher ID'
                    ];
                }

                $voucher_code = $this->generate_unique_voucher_code($bulk_prefix, $mst_itemgiftid, ($index + 1) . $row, $itemtype);

                if ($voucher_code === null) {
                    $this->db->trans_rollback();
                    return [
                        'success' => false,
                        'message' => 'Failed to generate unique voucher code'
                    ];
                }

                $data = [
                    'mst_voucherid' => $mst_voucherid,
                    'mst_itemgiftid' => $mst_itemgiftid,
                    'voucher_code' => $voucher_code,
                    'voucher_key' => $this->build_voucher_key($voucher_code),
                    'status' => $status,
                    'expired_date' => $expired_date,
                    'redeemed_date' => null,
                    'created_by' => $current_user,
                    'created_date' => date('Y-m-d H:i:s'),
                    'bulk_code' => $bulk_code,
                    'bulk_seq' => $bulk_seq
                ];

                $insert = $this->db->insert($this->_table, $data);

                if (!$insert) {
                    $this->db->trans_rollback();
                    return [
                        'success' => false,
                        'message' => 'Failed to create bulk voucher data'
                    ];
                }

                $created_rows[] = $data;
            }
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return [
                'success' => false,
                'message' => 'Failed to create bulk voucher data'
            ];
        }

        $this->db->trans_commit();

        return [
            'success' => true,
            'message' => 'Bulk voucher data created successfully',
            'data' => [
                'bulk_code' => $bulk_code,
                'created_count' => count($created_rows),
                'rows' => $created_rows
            ]
        ];
    }

    public function data_edit($id)
    {
        $item = $this->db->select('v.*, g.itemname, g.itemtype')
            ->from($this->_table . ' v')
            ->join('mst_itemgift g', 'g.mst_itemgiftid = v.mst_itemgiftid', 'left')
            ->where('v.mst_voucherid', (int) $id)
            ->get()
            ->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Voucher data not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Voucher data retrieved successfully',
            'data' => $item
        ];
    }

    public function verification($voucher_key)
    {
        $voucher_key = trim((string) $voucher_key);
        if ($voucher_key === '') {
            return [
                'success' => false,
                'message' => 'Voucher key is required',
                'verified' => false,
                'data' => null
            ];
        }

        $item = $this->db->select('v.mst_voucherid, v.mst_itemgiftid, v.status, 
                v.expired_date, v.redeemed_date, g.itemname, g.itemtype')
            ->from($this->_table . ' v')
            ->join('mst_itemgift g', 'g.mst_itemgiftid = v.mst_itemgiftid', 'left')
            ->where('v.voucher_key', $voucher_key)
            ->get()
            ->row();

        if (!$item) {
            return [
                'success' => true,
                'message' => 'Voucher not found',
                'verified' => false,
                'data' => null
            ];
        }

        $status_map = [
            1 => 'CREATED',
            2 => 'PRINTED',
            3 => 'REDEEMED',
            4 => 'COMPLETED',
            5 => 'REJECTED'
        ];

        $item->status_label = $status_map[(int) ($item->status ?? 0)] ?? 'UNKNOWN';

        $is_expired = false;
        if (!empty($item->expired_date)) {
            $now = new DateTime();
            $expired = new DateTime($item->expired_date);
            $is_expired = $now > $expired;
        }

        $can_claim = (int) $item->status === 1 && !$is_expired;

        if ($is_expired) {
            $item->status_label = 'EXPIRED';
        }

        return [
            'success' => true,
            'message' => $is_expired ? 'Voucher has expired' : 'Voucher verified successfully',
            'verified' => true,
            'can_claim' => $can_claim,
            'is_expired' => $is_expired,
            'data' => $item
        ];
    }

    public function claim_gift($voucher_key, $mst_customerid, array $context = [])
    {
        $voucher_key = trim((string) $voucher_key);
        $mst_customerid = $this->normalize_itemgiftid($mst_customerid);
        $description = trim((string) ($context['description'] ?? ''));
        $useragent = trim((string) ($context['useragent'] ?? ''));
        $ip_address = trim((string) ($context['ip_address'] ?? ''));
        $mac_address = trim((string) ($context['mac_address'] ?? ''));
        $geo_lat = $this->normalize_nullable_float($context['geo_lat'] ?? null);
        $geo_long = $this->normalize_nullable_float($context['geo_long'] ?? null);
        $customer_payload = is_array($context['customer'] ?? null) ? $context['customer'] : [];
        $uploaded_file = $context['uploaded_file'] ?? null;

        if ($voucher_key === '') {
            return ['success' => false, 'message' => 'Voucher key is required', 'error_type' => 'general'];
        }

        $customer = null;
        $new_customer_id = null;

        if ($mst_customerid !== null) {
            $customer = $this->customer_exists($mst_customerid);
            if (!$customer) {
                return ['success' => false, 'message' => 'Customer data not found', 'error_type' => 'customer'];
            }
        } else {
            $custname = trim((string) ($customer_payload['custname'] ?? ''));
            $phone_number = trim((string) ($customer_payload['phone_number'] ?? ''));
            $email = trim((string) ($customer_payload['email'] ?? ''));
            $mst_reg_provinceid = $this->normalize_itemgiftid($customer_payload['mst_reg_provinceid'] ?? null);
            $mst_reg_cityid = $this->normalize_itemgiftid($customer_payload['mst_reg_cityid'] ?? null);
            $mst_reg_districtid = $this->normalize_itemgiftid($customer_payload['mst_reg_districtid'] ?? null);
            $mst_reg_villageid = $this->normalize_itemgiftid($customer_payload['mst_reg_villageid'] ?? null);

            if ($custname === '' || $phone_number === '' || $email === '' || $mst_reg_provinceid === null || $mst_reg_cityid === null || $mst_reg_districtid === null) {
                return ['success' => false, 'message' => 'Customer data is required', 'error_type' => 'customer'];
            }
        }

        $uploaded_path = null;

        if ($uploaded_file !== null) {
            $upload_result = $this->validate_and_upload_proof($uploaded_file, $uploaded_path);
            if (!$upload_result['success']) {
                return ['success' => false, 'message' => $upload_result['message'], 'error_type' => 'purchase_proof'];
            }
        }

        $this->db->trans_begin();

        try {
            $sql = $this->db->select('v.*, g.itemtype, g.itemname')
                ->from($this->_table . ' v')
                ->join('mst_itemgift g', 'g.mst_itemgiftid = v.mst_itemgiftid', 'left')
                ->where('v.voucher_key', $voucher_key)
                ->where('v.status', 1)
                ->get_compiled_select();
            $sql .= ' FOR UPDATE OF v';
            $voucher = $this->db->query($sql)->row();

            if (!$voucher) {
                throw new Exception('Voucher data not found or already claimed');
            }

            if (!empty($voucher->expired_date)) {
                $now = new DateTime();
                $expired = new DateTime($voucher->expired_date);
                if ($now > $expired) {
                    throw new Exception('Voucher has expired');
                }
            }

            $act_redeemid = $this->Global_Model->get_autoid('act_redeem', 'act_redeemid');
            if ($act_redeemid === null) {
                throw new Exception('Failed to generate redeem ID');
            }

            $target_status = ((int) $voucher->itemtype === 2) ? 4 : 3;

            if ($mst_customerid === null) {
                $this->load->model('Customer_Model');
                $customer_create = $this->Customer_Model->data_new([
                    'custname' => $custname ?? '',
                    'phone_number' => $phone_number ?? '',
                    'email' => $email ?? '',
                    'mst_reg_provinceid' => $mst_reg_provinceid ?? NULL,
                    'mst_reg_cityid' => $mst_reg_cityid ?? NULL,
                    'mst_reg_districtid' => $mst_reg_districtid ?? NULL,
                    'mst_reg_villageid' => $mst_reg_villageid ?? NULL
                ]);

                if (!$customer_create['success']) {
                    throw new Exception($customer_create['message'] ?? 'Failed to create customer data');
                }

                $customer = $this->db->select('mst_customerid, custname, phone_number, email')
                    ->from('mst_customer')
                    ->where('phone_number', $phone_number ?? '')
                    ->order_by('mst_customerid', 'DESC')
                    ->limit(1)
                    ->get()
                    ->row();

                if (!$customer) {
                    throw new Exception('Customer data not found after creation');
                }

                $new_customer_id = $customer->mst_customerid;
            } else {
                $new_customer_id = $customer->mst_customerid;
            }

            $redeem_data = [
                'act_redeemid' => $act_redeemid,
                'mst_customerid' => (int) $new_customer_id,
                'mst_voucherid' => (int) $voucher->mst_voucherid,
                'description' => $description,
                'ip_address' => $ip_address,
                'mac_address' => $mac_address,
                'useragent' => $useragent,
                'geo_lat' => $geo_lat,
                'geo_long' => $geo_long,
                'redeemed_date' => date('Y-m-d H:i:s'),
                'confirmed_by' => '',
                'confirmed_date' => null,
                'completed_by' => '',
                'completed_date' => null
            ];

            $insert_redeem = $this->db->insert('act_redeem', $redeem_data);
            if (!$insert_redeem) {
                throw new Exception('Failed to insert redeem record');
            }

            $this->db->where('mst_voucherid', (int) $voucher->mst_voucherid);
            $this->db->where('status', 1);
            $this->db->update($this->_table, [
                'status' => $target_status,
                'redeemed_date' => date('Y-m-d H:i:s'),
                'modified_date' => date('Y-m-d H:i:s'),
            ]);
            if ($this->db->affected_rows() === 0) {
                throw new Exception('Voucher already claimed by another request');
            }

            if ($uploaded_path !== null) {
                $proof_id = $this->Global_Model->get_autoid('act_redeem_purchase_proof', 'act_redeem_purchase_proofid');
                if ($proof_id === null) {
                    throw new Exception('Failed to generate purchase proof ID');
                }

                $proof_data = [
                    'act_redeem_purchase_proofid' => (int) $proof_id,
                    'act_redeemid' => (int) $act_redeemid,
                    'filename' => $uploaded_file['name'],
                    'filepath' => $uploaded_path,
                    'created_by' => 'customer',
                    'created_date' => date('Y-m-d H:i:s')
                ];

                $insert_proof = $this->db->insert('act_redeem_purchase_proof', $proof_data);
                if (!$insert_proof) {
                    throw new Exception('Failed to insert purchase proof record');
                }
            }

            if ($this->db->trans_status() === false) {
                throw new Exception('Transaction failed');
            }

            $this->db->trans_commit();
        } catch (Exception $e) {
            $this->db->trans_rollback();

            if ($uploaded_path !== null) {
                $full_path = FCPATH . $uploaded_path;
                if (file_exists($full_path)) {
                    @unlink($full_path);
                }
            }

            return ['success' => false, 'message' => $e->getMessage(), 'error_type' => strpos($e->getMessage(), 'purchase proof') !== false ? 'purchase_proof' : 'general'];
        }

        $this->load->model('Email_Model');
        $this->Email_Model->emailRedeemToAdmin($act_redeemid);
        $this->Email_Model->emailConfirmToCustomer($act_redeemid);

        $this->load->model('Notification_Model');
        $cust_name = $customer->custname ?? 'Customer';
        $v_code = $voucher->voucher_code ?? '';
        $item_name = !empty($voucher->itemname) ? $voucher->itemname : 'Item Gift';

        $admin_ids = $this->Notification_Model->get_admin_ids_with_menu(114);
        if (!empty($admin_ids)) {
            foreach ($admin_ids as $admin_id) {
                $this->Notification_Model->data_new('redeem', 'New Redeem', $cust_name . ' redeemed ' . $v_code . ' (' . $item_name . ')', $act_redeemid, $admin_id);
            }
        } else {
            $this->Notification_Model->data_new('redeem', 'New Redeem', $cust_name . ' redeemed ' . $v_code . ' (' . $item_name . ')', $act_redeemid);
        }

        $push_result = $this->Notification_Model->send_push('New Redeem', $cust_name . ' redeemed ' . $item_name, 'activities/redeem');

        return [
            'success' => true,
            'message' => 'Gift claimed successfully',
            'data' => [
                'act_redeemid' => (int) $act_redeemid,
                'mst_voucherid' => (int) $voucher->mst_voucherid,
                'voucher_status' => (int) $target_status,
                'customer' => [
                    'mst_customerid' => (int) $customer->mst_customerid
                ]
            ]
        ];
    }

    public function data_update($id, array $input)
    {
        $item = $this->db->get_where($this->_table, [
            'mst_voucherid' => (int) $id
        ])->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Voucher data not found'
            ];
        }

        $mst_itemgiftid = $this->normalize_itemgiftid($input['mst_itemgiftid'] ?? $item->mst_itemgiftid);
        $voucher_code = trim((string) ($input['voucher_code'] ?? $item->voucher_code));
        $expired_date = $this->normalize_date(array_key_exists('expired_date', $input) ? $input['expired_date'] : $item->expired_date);
        $current_user = $this->current_user_id()->username;

        if ($mst_itemgiftid === null) {
            return [
                'success' => false,
                'message' => 'Item gift is required'
            ];
        }

        if (!$this->itemgift_exists($mst_itemgiftid)) {
            return [
                'success' => false,
                'message' => 'Item gift data not found'
            ];
        }

        $this->db->where('voucher_code', $voucher_code);
        $this->db->where('mst_voucherid !=', (int) $id);
        if ($this->db->count_all_results($this->_table) > 0) {
            return [
                'success' => false,
                'message' => 'Voucher code is already in use'
            ];
        }

        if ($expired_date !== null && $expired_date <= date('Y-m-d 23:59:59')) {
            return [
                'success' => false,
                'message' => 'Expired date must be greater than today'
            ];
        }

        $data = [
            'mst_itemgiftid' => $mst_itemgiftid,
            'voucher_code' => $voucher_code,
            'voucher_key' => $this->build_voucher_key($voucher_code),
            'status' => (int) $item->status,
            'expired_date' => $expired_date,
            'modified_by' => $current_user,
            'modified_date' => date('Y-m-d H:i:s')
        ];

        $this->db->where('mst_voucherid', (int) $id);
        $update = $this->db->update($this->_table, $data);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'Voucher data updated successfully' : 'Failed to update voucher data'
        ];
    }

    public function data_delete($id)
    {
        $item = $this->db->get_where($this->_table, [
            'mst_voucherid' => (int) $id
        ])->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Voucher data not found'
            ];
        }

        if ((int) $item->status !== 1) {
            return [
                'success' => false,
                'message' => 'Only CREATED voucher can be deleted'
            ];
        }

        $delete = $this->db->delete($this->_table, [
            'mst_voucherid' => (int) $id
        ]);

        return [
            'success' => (bool) $delete,
            'message' => $delete ? 'Voucher data deleted successfully' : 'Failed to delete voucher data'
        ];
    }

    public function api_verification($voucher_key)
    {
        $voucher_key = trim((string) $voucher_key);
        if ($voucher_key === '') {
            return [
                'success' => false,
                'message' => 'Code is required',
                'response_code' => 'CODE_REQUIRED'
            ];
        }

        $item = $this->db->select('
                v.mst_voucherid, v.mst_itemgiftid, v.status,
                v.expired_date, v.redeemed_date, g.itemname, g.itemtype, g.value')
            ->from($this->_table . ' v')
            ->join('mst_itemgift g', 'g.mst_itemgiftid = v.mst_itemgiftid', 'left')
            ->where('v.voucher_key', $voucher_key)
            ->get()
            ->row();

        if (!$item) {
            return [
                'success' => false,
                'message' => 'Code not found',
                'response_code' => 'CODE_NOT_FOUND'
            ];
        }

        $status_map = [
            1 => 'CREATED',
            2 => 'PRINTED',
            3 => 'REDEEMED',
            4 => 'COMPLETED',
            5 => 'REJECTED'
        ];

        $item->status_label = $status_map[(int) ($item->status ?? 0)] ?? 'UNKNOWN';

        $is_expired = false;
        if (!empty($item->expired_date)) {
            $now = new DateTime();
            $expired = new DateTime($item->expired_date);
            $is_expired = $now > $expired;
        }

        $can_claim = (int) $item->status === 1 && !$is_expired;

        if ($is_expired) {
            return [
                'success' => false,
                'message' => 'Code expired',
                'response_code' => 'CODE_EXPIRED'
            ];
        }

        if ($can_claim == false) {
            return [
                'success' => false,
                'message' => 'Code already claimed',
                'response_code' => 'CODE_ALREADY_CLAIM'
            ];
        }

        return [
            'success' => true,
            'message' => 'Code verified successfully',
            'response_code' => 'CODE_VERIFIED',
            'data' => [
                'is_valid' => (bool) $can_claim,
                'is_expired' => (bool) $is_expired,
                'value' => (int) $item->value,
            ],
        ];
    }

    public function api_claim($voucher_key, $mst_customerid = null, array $context = [])
    {
        $voucher_key = trim((string) $voucher_key);
        $useragent = trim((string) ($context['useragent'] ?? ''));
        $ip_address = trim((string) ($context['ip_address'] ?? ''));
        $mac_address = trim((string) ($context['mac_address'] ?? ''));
        $geo_lat = $this->normalize_nullable_float($context['geo_lat'] ?? null);
        $geo_long = $this->normalize_nullable_float($context['geo_long'] ?? null);

        if ($voucher_key === '') {
            return [
                'success' => false,
                'message' => 'Code is required',
                'response_code' => 'CLAIM_FIELD_REQUIRED'
            ];
        }

        $this->db->trans_begin();

        try {
            $sql = $this->db->select('v.*, g.itemtype, g.itemname, g.value')
                ->from($this->_table . ' v')
                ->join('mst_itemgift g', 'g.mst_itemgiftid = v.mst_itemgiftid', 'left')
                ->where('v.voucher_key', $voucher_key)
                ->where('v.status', 1)
                ->get_compiled_select();
            $sql .= ' FOR UPDATE OF v';
            $voucher = $this->db->query($sql)->row();

            if (!$voucher) {
                throw new Exception('CODE_NOT_FOUND');
            }

            if (!empty($voucher->expired_date)) {
                $now = new DateTime();
                $expired = new DateTime($voucher->expired_date);
                if ($now > $expired) {
                    throw new Exception('CODE_EXPIRED');
                }
            }

            $act_redeemid = $this->Global_Model->get_autoid('act_redeem', 'act_redeemid');
            if ($act_redeemid === null) {
                throw new Exception('CLAIM_FAILED');
            }

            $target_status = ((int) $voucher->itemtype === 2) ? 4 : 3;
            $target_status = (int) 4; // Mark as Completed

            $redeem_data = [
                'act_redeemid' => $act_redeemid,
                'mst_customerid' => $mst_customerid !== null ? (int) $mst_customerid : NULL,
                'mst_voucherid' => (int) $voucher->mst_voucherid,
                'ip_address' => $ip_address,
                'mac_address' => $mac_address,
                'useragent' => $useragent,
                'redeemed_date' => date('Y-m-d H:i:s'),
                'confirmed_by' => '',
                'confirmed_date' => null,
                'completed_by' => '',
                'completed_date' => null
            ];

            $insert_redeem = $this->db->insert('act_redeem', $redeem_data);
            if (!$insert_redeem) {
                throw new Exception('CLAIM_FAILED');
            }

            $this->db->where('mst_voucherid', (int) $voucher->mst_voucherid);
            $this->db->where('status', 1);
            $this->db->update($this->_table, [
                'status' => $target_status,
                'redeemed_date' => date('Y-m-d H:i:s'),
                'modified_date' => date('Y-m-d H:i:s'),
            ]);
            if ($this->db->affected_rows() === 0) {
                throw new Exception('CLAIM_RACE_CONDITION');
            }

            if ($this->db->trans_status() === false) {
                throw new Exception('CLAIM_FAILED');
            }

            $this->db->trans_commit();
        } catch (Exception $e) {
            $this->db->trans_rollback();

            $code = $e->getMessage();

            if ($code === 'CODE_NOT_FOUND') {
                return [
                    'success' => false,
                    'message' => 'Code not found or already claimed',
                    'response_code' => 'CLAIM_NOT_FOUND'
                ];
            }

            if ($code === 'CODE_EXPIRED') {
                return [
                    'success' => false,
                    'message' => 'Code has expired',
                    'response_code' => 'CLAIM_EXPIRED'
                ];
            }

            if ($code === 'CLAIM_RACE_CONDITION') {
                return [
                    'success' => false,
                    'message' => 'Code already claimed by another request',
                    'response_code' => 'CLAIM_RACE_CONDITION'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to claim code',
                'response_code' => 'CLAIM_FAILED'
            ];
        }

        $this->load->model('Notification_Model');
        $v_code = $voucher->voucher_code ?? '';
        $item_name = !empty($voucher->itemname) ? $voucher->itemname : 'Item Gift';

        $admin_ids = $this->Notification_Model->get_admin_ids_with_menu(114);
        if (!empty($admin_ids)) {
            foreach ($admin_ids as $admin_id) {
                $this->Notification_Model->data_new('redeem', 'New Redeem', $v_code . ' (' . $item_name . ') claimed', $act_redeemid, $admin_id);
            }
        } else {
            $this->Notification_Model->data_new('redeem', 'New Redeem', $v_code . ' (' . $item_name . ') claimed', $act_redeemid);
        }

        $this->Notification_Model->send_push('New Redeem', $v_code . ' (' . $item_name . ') claimed', 'activities/redeem');

        return [
            'success' => true,
            'message' => 'Point claimed successfully',
            'response_code' => 'CLAIM_SUCCESS',
            'data' => [
                'value' => (int) $voucher->value
            ]
        ];
    }

    public function data_bulk_list()
    {
        $bulk_list = $this->db
            ->select('
                DISTINCT(a.bulk_code),
                MAX(a.created_date) AS bulk_created_date,
                CAST(COUNT(a.mst_voucherid) AS INTEGER) AS bulk_count
            ')
            ->from($this->_table . ' a')
            ->group_by('a.bulk_code')
            ->order_by('bulk_created_date', 'DESC')
            ->get()
            ->result();

        if ($bulk_list) {
            return $bulk_list;
        } else {
            return array();
        }
    }
}
