-- Seed admin + grant seluruh menu
-- Username : gpdi
-- Password : TuhanYesus (bcrypt, PASSWORD_BCRYPT cost 12 — diverifikasi Auth_Model::login via password_verify)
-- Prasyarat:
--   * set_menu sudah terisi  -> jalankan 2026-09-26-00001.sql lebih dulu
--   * INSERT IGNORE agar aman dijalankan berulang

-- 1. Admin (mst_adminid 1, suspended = 0 supaya bisa login)
INSERT IGNORE INTO `mst_admin`
  (`mst_adminid`, `username`, `password`, `suspended`, `created_by`, `created_date`, `email`)
VALUES
  (1, 'gpdi', '$2y$12$kBkylU6JOFhHOGwdhHtDJ.w9KlDUSF9ZILlkEkMvjwAO1xaDa2VQW', 0, 'seed', NOW(6), NULL);

-- 2. Grant akses semua menu (root + sub menu Region) ke admin id 1
INSERT IGNORE INTO `set_menu_admin`
  (`set_menuid`, `mst_adminid`, `view`, `new`, `update`, `delete`, `print`, `export`)
SELECT `set_menuid`, 1, 1, 1, 1, 1, 1, 1
  FROM `set_menu`;
 