<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Security extends CI_Security
{
    public function csrf_set_cookie()
    {
        $expire = time() + $this->_csrf_expire;
        $secure_cookie = (bool) config_item('cookie_secure');

        if ($secure_cookie && ! is_https())
        {
            return FALSE;
        }

        if (is_php('7.3'))
        {
            setcookie(
                $this->_csrf_cookie_name,
                $this->_csrf_hash,
                array(
                    'expires'  => $expire,
                    'path'     => config_item('cookie_path'),
                    'domain'   => config_item('cookie_domain'),
                    'secure'   => $secure_cookie,
                    'httponly' => config_item('cookie_httponly'),
                    'samesite' => 'Lax'
                )
            );
        }
        else
        {
            $domain = trim(config_item('cookie_domain'));
            header('Set-Cookie: '.$this->_csrf_cookie_name.'='.$this->_csrf_hash
                    .'; Expires='.gmdate('D, d-M-Y H:i:s T', $expire)
                    .'; Max-Age='.$this->_csrf_expire
                    .'; Path='.rawurlencode(config_item('cookie_path'))
                    .($domain === '' ? '' : '; Domain='.$domain)
                    .($secure_cookie ? '; Secure' : '')
                    .(config_item('cookie_httponly') ? '; HttpOnly' : '')
                    .'; SameSite=Lax'
            );
        }

        log_message('info', 'CSRF cookie sent (SameSite=Lax)');
        return $this;
    }
}
