<?php

class Auth_Model extends CI_Model
{
    private $_table = "mst_admin";
    const SESSION_KEY = 'mst_adminid';

    public function __construct()
    {
        $this->load->model('Global_Model');
    }

    public function rules()
    {
        return [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|max_length[255]'
            ]
        ];
    }

    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('suspended', 0);
        $query = $this->db->get($this->_table);
        $user = $query->row();

        if (!$user) {
            return FALSE;
        }

        if (!password_verify($password, $user->password)) {
            return FALSE;
        }

        $this->session->set_userdata([
            'mst_adminid' => $user->mst_adminid,
            'username' => $user->username,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->Global_Model->get_useragent(),
            'mac_address' => $this->Global_Model->get_mac(),
            'logged_in_at' => time()
        ]);
        $this->session->sess_regenerate(TRUE);

        return $this->session->has_userdata(self::SESSION_KEY);
    }

    public function current_user()
    {
        if (!$this->session->has_userdata(self::SESSION_KEY)) {
            return null;
        }

        $this->load->model('Database_Scanner');
        $current_db = $this->Database_Scanner->get_current_database();

        if ($this->db->database !== $current_db && !empty($current_db)) {
            $switched = $this->Database_Scanner->switch_to_database($current_db);
            if (!$switched) {
                $this->session->unset_userdata('selected_database');
            }
        }

        // if ($this->session->userdata('user_agent') !== $this->input->user_agent()) {
        //     $this->logout();
        // }

        $user_id = $this->session->userdata(self::SESSION_KEY);
        $query = $this->db->get_where($this->_table, [
            'mst_adminid' => $user_id,
            'suspended' => 0
        ]);
        $user = $query->row();

        if (!$user) {
            $this->session->unset_userdata(self::SESSION_KEY);
            return null;
        }

        if ($user->force_logout_at && $this->session->userdata('logged_in_at') < strtotime($user->force_logout_at)) {
            $this->logout();
            return null;
        }

        return $user;
    }

    public function logout()
    {
        $this->session->unset_userdata(self::SESSION_KEY);
        $this->session->unset_userdata('selected_database');
        return !$this->session->has_userdata(self::SESSION_KEY);
    }

    public function change_password($mst_adminid, $current_password, $new_password)
    {
        $mst_adminid = (int) $mst_adminid;
        $current_password = (string) $current_password;
        $new_password = (string) $new_password;

        if ($mst_adminid <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid user account'
            ];
        }

        $user = $this->db->get_where($this->_table, [
            'mst_adminid' => $mst_adminid,
            'suspended' => 0
        ])->row();

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Account not found'
            ];
        }

        if (!password_verify($current_password, $user->password)) {
            return [
                'success' => false,
                'message' => 'Current password is incorrect'
            ];
        }

        $update = $this->db->update($this->_table, [
            'password' => password_hash($new_password, PASSWORD_BCRYPT),
            'modified_date' => date('Y-m-d H:i:s')
        ], [
            'mst_adminid' => $mst_adminid
        ]);

        if (!$update) {
            return [
                'success' => false,
                'message' => 'Failed to update password'
            ];
        }

        return [
            'success' => true,
            'message' => 'Password updated successfully'
        ];
    }

    public function force_logout($mst_adminid)
    {
        $mst_adminid = (int) $mst_adminid;
        if ($mst_adminid <= 0) {
            return ['success' => false, 'message' => 'Invalid user ID'];
        }

        $update = $this->db->update($this->_table, [
            'force_logout_at' => date('Y-m-d H:i:s')
        ], [
            'mst_adminid' => $mst_adminid
        ]);

        if (!$update) {
            return ['success' => false, 'message' => 'Failed to force logout user'];
        }

        return ['success' => true, 'message' => 'User will be logged out on next request'];
    }
}
