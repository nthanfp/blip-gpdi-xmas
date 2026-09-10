<?php

class Database_Scanner extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->driver('cache', ['adapter' => 'file']);
    }

    public function get_available_databases()
    {
        $active_host = $this->db->hostname;
        $active_user = $this->db->username;
        $active_user = $active_user ?: (getenv('DB_USER_PROD') ?: getenv('DB_USER_DEV'));

        $cache_key = 'db_list_' . md5($active_host . '|' . $active_user);

        $cached = $this->cache->get($cache_key);
        if ($cached !== FALSE) {
            return $cached;
        }

        $prefixes = ['blip'];
        $available_dbs = [];

        try {
            $host = $this->db->hostname;
            $username = $this->db->username ?: (getenv('DB_USER_PROD') ?: getenv('DB_USER_DEV'));
            $password = $this->db->password ?: (getenv('DB_PASS_PROD') ?: getenv('DB_PASS_DEV'));
            $port = $this->db->port ?: (getenv('DB_PORT_PROD') ?: getenv('DB_PORT_DEV')) ?: 5432;

            $conn = @mysqli_connect($host, $username, $password, '', $port);

            if (!$conn) {
                return [];
            }

            $result = @mysqli_query($conn, "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME");

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $db_name = $row['SCHEMA_NAME'];
                    foreach ($prefixes as $prefix) {
                        if (strpos($db_name, $prefix) === 0) {
                            $available_dbs[] = [
                                'name' => $db_name,
                                'display' => ucfirst(str_replace('_', ' ', $db_name))
                            ];
                            break;
                        }
                    }
                }
            }

            mysqli_close($conn);
            $this->cache->save($cache_key, $available_dbs, 3600);

            return $available_dbs;
        } catch (Exception $e) {
            return [];
        }
    }

    public function get_current_database()
    {
        $selected = $this->session->userdata('selected_database');
        if ($selected) {
            return $selected;
        }
        return $this->db->database;
    }

    public function validate_database($db_name)
    {
        $available = $this->get_available_databases();
        $valid_names = array_column($available, 'name');

        return in_array($db_name, $valid_names, true);
    }

    public function switch_to_database($db_name)
    {
        if (!$db_name) {
            return false;
        }

        if (isset($this->db->conn_id) && $this->db->database === $db_name) {
            return true;
        }

        if (!$this->validate_database($db_name)) {
            return false;
        }

        $config = [
            'dsn' => '',
            'hostname' => $this->db->hostname,
            'username' => $this->db->username,
            'password' => $this->db->password,
            'database' => $db_name,
            'dbdriver' => $this->db->dbdriver,
            'port' => $this->db->port,
            'dbprefix' => '',
            'pconnect' => FALSE,
            'db_debug' => FALSE,
            'cache_on' => FALSE,
            'cachedir' => '',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => FALSE
        ];

        $this->db->close();
        $new_db = $this->load->database($config, TRUE);

        if ($new_db && $new_db->conn_id) {
            $CI =& get_instance();
            $CI->db = $new_db;
            return true;
        }

        $this->load->database();
        return false;
    }

    public function clear_cache()
    {
        $cache_key = 'db_list_' . md5(json_encode([
            getenv('DB_HOST_PROD') ?: getenv('DB_HOST_DEV'),
            getenv('DB_USER_PROD') ?: getenv('DB_USER_DEV'),
        ]));
        $this->cache->delete($cache_key);
    }
}
