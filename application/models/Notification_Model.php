<?php

class Notification_Model extends CI_Model
{
    private $_table = 'act_admin_notifications';
    private $_token_table = 'act_admin_fcm_tokens';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Global_Model');
        $this->config->load('firebase');
    }

    // ===== In-app notifications =====

    public function data_new($type, $title, $message, $related_id = null, $mst_adminid = null)
    {
        $id = $this->Global_Model->get_autoid_seq('act_admin_notification_seq');
        if ($id === null) {
            return ['success' => false, 'message' => 'Failed to generate notification ID'];
        }

        $data = [
            'act_admin_notificationid' => $id,
            'type' => trim((string) $type),
            'title' => trim((string) $title),
            'message' => trim((string) $message),
            'related_id' => $related_id ? (int) $related_id : null,
            'mst_adminid' => $mst_adminid ? (int) $mst_adminid : null,
            'is_read' => 0,
            'created_date' => date('Y-m-d H:i:s')
        ];

        $insert = $this->db->insert($this->_table, $data);
        return ['success' => (bool) $insert];
    }

    public function data_unread_count($admin_id = null)
    {
        $this->db->where('is_read', 0);
        if ($admin_id !== null) {
            $this->db->where('mst_adminid', (int) $admin_id);
        }
        return (int) $this->db->count_all_results($this->_table);
    }

    public function data_recent($limit = 10, $admin_id = null)
    {
        if ($admin_id !== null) {
            $this->db->where('mst_adminid', (int) $admin_id);
        }
        return $this->db->order_by('created_date', 'DESC')
            ->order_by('act_admin_notificationid', 'DESC')
            ->limit((int) $limit)
            ->get($this->_table)
            ->result();
    }

    public function data_mark_read($id, $admin_id = null)
    {
        $this->db->where('act_admin_notificationid', (int) $id);
        if ($admin_id !== null) {
            $this->db->where('mst_adminid', (int) $admin_id);
        }
        return $this->db->update($this->_table, ['is_read' => 1]);
    }

    public function data_mark_all_read($admin_id = null)
    {
        $this->db->where('is_read', 0);
        if ($admin_id !== null) {
            $this->db->where('mst_adminid', (int) $admin_id);
        }
        return $this->db->update($this->_table, ['is_read' => 1]);
    }

    public function get_admin_ids_with_menu($menuid)
    {
        $rows = $this->db->select('a.mst_adminid')
            ->from('mst_admin a')
            ->join('set_menu_admin sm', 'sm.mst_adminid = a.mst_adminid')
            ->where('a.suspended', 0)
            ->where('sm.set_menuid', (int) $menuid)
            ->get()
            ->result();

        return array_map(function ($row) {
            return (int) $row->mst_adminid;
        }, $rows);
    }

    // ===== FCM tokens =====

    public function save_token($mst_adminid, $fcm_token)
    {
        $existing = $this->db->where('mst_adminid', (int) $mst_adminid)
            ->where('fcm_token', $fcm_token)
            ->get($this->_token_table)
            ->row();

        if ($existing) {
            return $this->db->where('id', $existing->id)
                ->update($this->_token_table, ['updated_date' => date('Y-m-d H:i:s')]);
        }

        $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

        $browser_key = $this->_browser_family($ua);

        if ($browser_key) {
            $this->db->where('mst_adminid', (int) $mst_adminid);
            $this->db->where('user_agent LIKE', $browser_key . '%');
            $this->db->delete($this->_token_table);
        }

        return $this->db->insert($this->_token_table, [
            'mst_adminid' => (int) $mst_adminid,
            'fcm_token' => $fcm_token,
            'user_agent' => $ua,
            'created_date' => date('Y-m-d H:i:s'),
            'updated_date' => date('Y-m-d H:i:s')
        ]);
    }

    private function _browser_family($ua)
    {
        if (stripos($ua, 'Firefox') !== false) return 'Firefox/';
        if (stripos($ua, 'Edg') !== false) return 'Edg/';
        if (stripos($ua, 'Samsung') !== false) return 'SamsungBrowser/';
        if (stripos($ua, 'Chrome') !== false) return 'Chrome/';
        if (stripos($ua, 'Safari') !== false) return 'Safari/';
        return '';
    }

    public function remove_token($fcm_token)
    {
        return $this->db->where('fcm_token', $fcm_token)->delete($this->_token_table);
    }

    public function remove_tokens_by_admin($admin_id)
    {
        return $this->db->where('mst_adminid', (int) $admin_id)->delete($this->_token_table);
    }

    public function get_all_tokens()
    {
        $rows = $this->db->select('fcm_token')
            ->get($this->_token_table)
            ->result();

        $tokens = [];
        foreach ($rows as $row) {
            $tokens[] = $row->fcm_token;
        }
        return $tokens;
    }

    public function get_admin_tokens($admin_id)
    {
        $rows = $this->db->select('fcm_token')
            ->where('mst_adminid', $admin_id)
            ->get($this->_token_table)
            ->result();

        $tokens = [];
        foreach ($rows as $row) {
            $tokens[] = $row->fcm_token;
        }
        return $tokens;
    }

    // ===== FCM token listing (admin) =====

    public function data_list($page = 1, $per_page = 10, $search = '')
    {
        $this->db->from($this->_token_table . ' t');
        $this->db->join('mst_admin a', 'a.mst_adminid = t.mst_adminid', 'left');

        if ($search !== '') {
            $this->db->group_start()
                ->like('a.username', $search)
                ->or_like('t.fcm_token', $search)
                ->or_like('t.user_agent', $search)
                ->group_end();
        }

        $total = $this->db->count_all_results('', false);

        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->select('t.*, a.username');
        $this->db->order_by('t.updated_date', 'DESC');
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'Tokens retrieved successfully',
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

    public function data_delete_token($id)
    {
        $item = $this->db->where('id', (int) $id)->get($this->_token_table)->row();
        if (!$item) {
            return ['success' => false, 'message' => 'Token not found'];
        }

        $delete = $this->db->delete($this->_token_table, ['id' => (int) $id]);

        return [
            'success' => (bool) $delete,
            'message' => $delete ? 'Token deleted successfully' : 'Failed to delete token'
        ];
    }

    // ===== FCM Push via HTTP v1 =====

    private function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function get_access_token()
    {
        $json_raw = $this->config->item('fcm_service_account_json');
        $sa = json_decode($json_raw, true);

        if (!$sa || empty($sa['client_email']) || empty($sa['private_key'])) {
            return [null, 'Service account not configured'];
        }

        $now = time();
        $header = $this->base64url_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $payload = $this->base64url_encode(json_encode([
            'iss' => $sa['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ]));

        $signature = '';
        $pkey = openssl_get_privatekey($sa['private_key']);
        if (!$pkey) {
            return [null, 'Failed to load private key'];
        }

        openssl_sign($header . '.' . $payload, $signature, $pkey, 'sha256WithRSAEncryption');
        openssl_free_key($pkey);

        $jwt = $header . '.' . $payload . '.' . $this->base64url_encode($signature);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $res = curl_exec($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http !== 200) {
            return [null, 'OAuth token request failed: HTTP ' . $http];
        }

        $data = json_decode($res, true);
        if (!$data || empty($data['access_token'])) {
            return [null, 'Invalid OAuth response'];
        }

        return [$data['access_token'], null];
    }

    public function send_push($title, $body, $click_url = null, $admin_id = null)
    {
        $tokens = $admin_id ? $this->get_admin_tokens($admin_id) : $this->get_all_tokens();
        if (empty($tokens)) return ['success' => false, 'message' => 'No FCM tokens saved. Push notifications require HTTPS — browser registers the token automatically when you first load the page on HTTPS'];

        $sa = json_decode($this->config->item('fcm_service_account_json'), true);
        $project_id = !empty($sa['project_id']) ? $sa['project_id'] : '';

        if (!$project_id) {
            return ['success' => false, 'message' => 'Project ID not found in service account'];
        }

        list($access_token, $error) = $this->get_access_token();
        if (!$access_token) {
            return ['success' => false, 'message' => $error];
        }

        $fcm_url = 'https://fcm.googleapis.com/v1/projects/' . $project_id . '/messages:send';
        $icon_url = base_url('assets/icons/android-chrome-192x192.png');
        $click_path = $click_url ? base_url($click_url) : base_url('index.php/activities/dashboard');

        $success_count = 0;
        $fail_count = 0;

        foreach ($tokens as $token) {
            $message = [
                'message' => [
                    'token' => $token,
                    'data' => [
                        'title' => $title,
                        'body' => $body,
                        'icon' => $icon_url,
                        'click_url' => $click_path
                    ]
                ]
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $fcm_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $access_token,
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($http_code === 200) {
                $success_count++;
            } else {
                $fail_count++;
                $res_data = json_decode($response, true);
                $error_code = !empty($res_data['error']['details'][0]['errorCode'])
                    ? $res_data['error']['details'][0]['errorCode']
                    : (!empty($res_data['error']['status']) ? $res_data['error']['status'] : '');
                if (in_array($error_code, ['UNREGISTERED', 'NOT_FOUND', 'TOKEN_NOT_FOUND'])) {
                    $this->remove_token($token);
                }
            }
            curl_close($ch);
        }

        return [
            'success' => $success_count > 0,
            'message' => 'Sent to ' . $success_count . ' device(s), ' . $fail_count . ' failed',
            'data' => [
                'success_count' => $success_count,
                'fail_count' => $fail_count
            ]
        ];
    }
}
