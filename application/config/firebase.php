<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ===== Firebase Cloud Messaging HTTP v1 =====
// Dapatkan service_account_json dari:
// Firebase Console → Project Settings → Service Accounts → Generate New Private Key
//
// File JSON disimpan di application/config/firebase-service-account.json (sudah di-gitignore).
// Untuk production, dapat diarahkan ke path di luar webroot via env FCM_SERVICE_ACCOUNT_FILE.

$sa_file = getenv('FCM_SERVICE_ACCOUNT_FILE') ?: __DIR__ . '/../../env/firebase-service-account.json';
$config['fcm_service_account_json'] = file_exists($sa_file) ? file_get_contents($sa_file) : '';
$config['fcm_vapid_key'] = getenv('FCM_VAPID_KEY') ?: '';
