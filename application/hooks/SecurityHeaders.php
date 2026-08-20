<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SecurityHeaders
{
    public function set_headers()
    {
        $CI =& get_instance();

        if (method_exists($CI->output, 'set_header')) {
            $CI->output->set_header('X-Frame-Options: DENY');
            $CI->output->set_header('X-Content-Type-Options: nosniff');
        }
    }
}
