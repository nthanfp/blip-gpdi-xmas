<?php
class Global_Model extends CI_Model
{
    function __construct()
    {
    }

    function get_autoid($tabel, $namafield)
    {
        $maxid = $this->db->query("SELECT max($namafield) + 1 as $namafield FROM $tabel")->row()->$namafield;
        if ($maxid == '' || !isset($maxid)) {
            $maxid = 1;
        }
        return $maxid;
    }

    function get_autoid_seq($table)
    {
        $result = $this->db->query("SELECT AUTO_INCREMENT AS id FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = '" . $table . "'")->row();
        $maxid = ($result) ? $result->id : null;
        if ($maxid == '' || !isset($maxid)) {
            $maxid = 1;
        }
        return $maxid;
    }

    function get_mac()
    {
        $_IP_SERVER = $_SERVER['SERVER_ADDR'];
        $_IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
        if ($_IP_ADDRESS == $_IP_SERVER) {
            ob_start();
            system('ipconfig /all');
            $_PERINTAH = ob_get_contents();
            ob_clean();
            $_PECAH = strpos($_PERINTAH, "Physical");
            $_HASIL = substr($_PERINTAH, ($_PECAH + 36), 17);
        } else {
            $_PERINTAH = "arp -a $_IP_ADDRESS";
            ob_start();
            system($_PERINTAH);
            $_HASIL = ob_get_contents();
            ob_clean();
            $_PECAH = strstr($_HASIL, $_IP_ADDRESS);
            $_PECAH_STRING = explode($_IP_ADDRESS, str_replace(" ", "", $_PECAH));
            if (
                isset($_PECAH_STRING[1]) &&
                strlen($_PECAH_STRING[1]) >= 17
            ) {
                $_HASIL = substr($_PECAH_STRING[1], 0, 17);
            } else {
                $_HASIL = '';
            }
        }

        return $_HASIL;
    }

    function get_useragent()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            return trim($_SERVER['HTTP_USER_AGENT']);
        }

        return '';
    }

    function get_ip_address()
    {
        if (!empty($_SERVER['REMOTE_ADDR'])) {
            return trim($_SERVER['REMOTE_ADDR']);
        }

        return '';
    }
}