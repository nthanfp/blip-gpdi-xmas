<?php

class Faq_Model extends CI_Model
{
    private $_table = 'set_faq';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Global_Model');
        $this->load->helper('global');
    }

    private function current_user_id()
    {
        $CI =& get_instance();
        if (!isset($CI->Auth_Model)) {
            $CI->load->model('Auth_Model');
        }
        $current_user = $CI->Auth_Model->current_user();
        return $current_user ? $current_user->mst_adminid : null;
    }

    public function rules($mode = 'create')
    {
        return [
            [
                'field' => 'question',
                'label' => 'Question',
                'rules' => 'required'
            ],
            [
                'field' => 'answer',
                'label' => 'Answer',
                'rules' => 'required'
            ],
            [
                'field' => 'sort_order',
                'label' => 'Sort Order',
                'rules' => 'integer|greater_than_equal_to[0]'
            ]
        ];
    }

    /* Daftar aktif untuk landing (section faq.php) */
    public function get_active()
    {
        return $this->db->select('set_faqid, question, answer, sort_order')
            ->from($this->_table)
            ->where('suspended', 0)
            ->order_by('sort_order', 'ASC')
            ->order_by('set_faqid', 'ASC')
            ->get()
            ->result();
    }

    public function data_list($page = 1, $per_page = 10, $search = '')
    {
        $page = max(1, (int) $page);
        $per_page = max(1, (int) $per_page);
        $offset = ($page - 1) * $per_page;

        $this->db->from($this->_table);

        if ($search !== '') {
            $this->db->group_start()
                ->like('question', $search)
                ->or_like('answer', $search)
                ->group_end();
        }

        $total = $this->db->count_all_results('', false);

        $this->db->order_by('sort_order', 'ASC');
        $this->db->order_by('set_faqid', 'ASC');
        $this->db->limit($per_page, $offset);
        $rows = $this->db->get()->result();

        return [
            'success' => true,
            'message' => 'FAQ retrieved successfully',
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

    public function data_new(array $input)
    {
        $question = trim((string) ($input['question'] ?? ''));
        $answer = trim((string) ($input['answer'] ?? ''));
        $sort_order = (int) ($input['sort_order'] ?? 0);
        $suspended = !empty($input['suspended']) ? 1 : 0;

        if ($question === '' || $answer === '') {
            return ['success' => false, 'message' => 'Question and answer are required'];
        }

        $set_faqid = $this->Global_Model->get_autoid_seq($this->_table);
        if ($set_faqid === null) {
            return ['success' => false, 'message' => 'Failed to generate FAQ ID'];
        }

        $data = [
            'set_faqid' => $set_faqid,
            'question' => $question,
            'answer' => $answer,
            'sort_order' => $sort_order,
            'suspended' => $suspended,
            'created_by' => $this->current_user_id(),
            'created_date' => date('Y-m-d H:i:s')
        ];

        $insert = $this->db->insert($this->_table, $data);

        return [
            'success' => (bool) $insert,
            'message' => $insert ? 'FAQ created successfully' : 'Failed to create FAQ'
        ];
    }

    public function data_edit($id)
    {
        $item = $this->db->get_where($this->_table, ['set_faqid' => (int) $id])->row();

        if (!$item) {
            return ['success' => false, 'message' => 'FAQ not found'];
        }

        return ['success' => true, 'message' => 'FAQ retrieved successfully', 'data' => $item];
    }

    public function data_update($id, array $input)
    {
        $item = $this->db->get_where($this->_table, ['set_faqid' => (int) $id])->row();
        if (!$item) {
            return ['success' => false, 'message' => 'FAQ not found'];
        }

        $question = trim((string) ($input['question'] ?? ''));
        $answer = trim((string) ($input['answer'] ?? ''));
        $sort_order = (int) ($input['sort_order'] ?? 0);
        $suspended = !empty($input['suspended']) ? 1 : 0;

        if ($question === '' || $answer === '') {
            return ['success' => false, 'message' => 'Question and answer are required'];
        }

        $data = [
            'question' => $question,
            'answer' => $answer,
            'sort_order' => $sort_order,
            'suspended' => $suspended,
            'modified_by' => $this->current_user_id(),
            'modified_date' => date('Y-m-d H:i:s')
        ];

        $this->db->where('set_faqid', (int) $id);
        $update = $this->db->update($this->_table, $data);

        return [
            'success' => (bool) $update,
            'message' => $update ? 'FAQ updated successfully' : 'Failed to update FAQ'
        ];
    }

    public function data_delete($id)
    {
        $item = $this->db->get_where($this->_table, ['set_faqid' => (int) $id])->row();
        if (!$item) {
            return ['success' => false, 'message' => 'FAQ not found'];
        }

        $delete = $this->db->delete($this->_table, ['set_faqid' => (int) $id]);

        return [
            'success' => (bool) $delete,
            'message' => $delete ? 'FAQ deleted successfully' : 'Failed to delete FAQ'
        ];
    }
}
