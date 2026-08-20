<?php

class Sync_Model extends CI_Model
{
    public function __construct() {}


    private function download_file($url, $destination)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $file_content = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch) || $http_code >= 400 || $file_content === false) {
            curl_close($ch);
            return false;
        }

        curl_close($ch);

        $dir = dirname($destination);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        $written = file_put_contents($destination, $file_content);
        if ($written === false || $written === 0) {
            return false;
        }

        return true;
    }

    public function sync_proof_purchase($start_date, $end_date)
    {
        $this->db->select('filepath, created_date');
        $this->db->from('act_redeem_purchase_proof');
        $this->db->where('created_date >=', $start_date . ' 00:00:00');
        $this->db->where('created_date <=', $end_date . ' 23:59:59');
        $query = $this->db->get();
        $records = $query->result();

        $upload_path = FCPATH . 'uploads/purchase-proof/';
        $remote_base_url = 'https://qrtag.internalgroup.id/';
        $processed = 0;
        $downloaded = 0;
        $errors = [];

        foreach ($records as $record) {
            $filepath = $record->filepath;
            $filename = basename($filepath);
            $local_file = $upload_path . $filename;

            if (file_exists($local_file)) {
                $processed++;
                continue;
            }

            $remote_url = $remote_base_url . $filepath;
            $result = $this->download_file($remote_url, $local_file);

            if ($result) {
                $downloaded++;
            } else {
                $errors[] = [
                    'filepath' => $filepath,
                    'reason' => 'Download failed'
                ];
            }
            $processed++;
        }

        return [
            'success' => true,
            'total_processed' => $processed,
            'downloaded' => $downloaded,
            'errors' => $errors
        ];
    }

    public function sync_proof_completed($start_date, $end_date)
    {
        $this->db->select('filepath, created_date');
        $this->db->from('act_redeem_proof');
        $this->db->where('created_date >=', $start_date . ' 00:00:00');
        $this->db->where('created_date <=', $end_date . ' 23:59:59');
        $this->db->where('filepath !=', '');
        $this->db->where('filepath IS NOT NULL');
        $query = $this->db->get();
        $records = $query->result();

        $upload_path = FCPATH . 'uploads/redeem-proof/';
        $remote_base_url = 'https://qrtag.internalgroup.id/';
        $processed = 0;
        $downloaded = 0;
        $errors = [];

        foreach ($records as $record) {
            $filepath = $record->filepath;
            $filename = basename($filepath);
            $local_file = $upload_path . $filename;

            if (file_exists($local_file)) {
                $processed++;
                continue;
            }

            $remote_url = $remote_base_url . $filepath;
            $result = $this->download_file($remote_url, $local_file);

            if ($result) {
                $downloaded++;
            } else {
                $errors[] = [
                    'filepath' => $filepath,
                    'reason' => 'Download failed'
                ];
            }
            $processed++;
        }

        return [
            'success' => true,
            'total_processed' => $processed,
            'downloaded' => $downloaded,
            'errors' => $errors
        ];
    }
}
