<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Telegram_Model extends CI_Model
{
    private $_api_base = 'https://api.telegram.org';

    public function is_configured()
    {
        return (getenv('TELEGRAM_BOT_TOKEN') ?: '') !== '' && (getenv('TELEGRAM_CHAT_ID') ?: '') !== '';
    }

    public function send_message($text)
    {
        $token = getenv('TELEGRAM_BOT_TOKEN') ?: '';
        $chat_id = getenv('TELEGRAM_CHAT_ID') ?: '';

        if ($token === '' || $chat_id === '') {
            log_message('info', 'Telegram: not configured (TELEGRAM_BOT_TOKEN / TELEGRAM_CHAT_ID empty)');
            return ['success' => false, 'message' => 'Telegram not configured'];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_api_base . '/bot' . $token . '/sendMessage');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        $res = curl_exec($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($http !== 200) {
            log_message('error', 'Telegram sendMessage failed: HTTP ' . $http . ' ' . $err . ' body=' . substr((string) $res, 0, 300));
            return ['success' => false, 'message' => 'Telegram HTTP ' . $http];
        }

        $data = json_decode((string) $res, true);
        if (empty($data['ok'])) {
            log_message('error', 'Telegram sendMessage not ok: ' . substr((string) $res, 0, 300));
            return ['success' => false, 'message' => 'Telegram send failed'];
        }

        return ['success' => true, 'message' => 'Sent'];
    }
}
