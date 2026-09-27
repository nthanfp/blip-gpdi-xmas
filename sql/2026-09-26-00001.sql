-- Seed menu wajib untuk set_menu
-- Alasan: beberapa controller menulis set_menuid hardcode ke act_log_admin (FK)
-- dan guard_menu_access/check_menu membutuhkan baris menu agar halaman tidak 404.
-- ID yang dipakai kode: 102,103,108,109,111,116,118,119,125,126,127,128
-- Catatan:
--   * parent root WAJIB NULL (bukan 0) agar tampil di sidebar (Setmenu_Model)
--   * suspended = 0, order < 9998 agar tampil
--   * INSERT IGNORE agar aman dijalankan berulang (baris yang sudah ada dilewati)

INSERT IGNORE INTO `set_menu` (`set_menuid`, `parent_set_menuid`, `name`, `path`, `suspended`, `order`, `icon`) VALUES
(108, NULL, 'Dashboard',  'activities/dashboard',        0, 10,  'fas fa-tachometer-alt'),
(103, NULL, 'Admin',      'activities/user',             0, 20,  'fas fa-users-cog'),
(102, NULL, 'Set Menu',   'activities/setmenu',          0, 30,  'fas fa-bars'),
(116, NULL, 'Set Pref',   'activities/setpref',          0, 40,  'fas fa-cog'),
(111, NULL, 'Log Admin',  'activities/logadmin',         0, 50,  'fas fa-clipboard-list'),
(124, NULL, 'Region',     '#',                           0, 60,  'fas fa-map'),
(125, 124,  'Province',   'activities/region_province',  0, 61,  'fas fa-map'),
(126, 124,  'City',       'activities/region_city',      0, 62,  'fas fa-city'),
(127, 124,  'District',   'activities/region_district',  0, 63,  'fas fa-building'),
(128, 124,  'Village',    'activities/region_village',   0, 64,  'fas fa-home'),
(118, NULL, 'Push Notif', 'activities/notification/push',0, 70,  'fas fa-paper-plane'),
(119, NULL, 'FCM Token',  'activities/fcmtoken',         0, 80,  'fas fa-mobile-alt'),
(109, NULL, 'Authentication', 'activities/authentication', 1, 999, 'fas fa-sign-in-alt');
-- 109 = log-only (dipakai Authentication.php log_activity LOGIN/Change password),
-- suspended = 1 supaya tidak tampil di sidebar, tapi tetap ada untuk FK act_log_admin.

-- (Opsional) grant semua menu ke admin id 1 — jalankan hanya jika sudah ada INSERT admin:
-- INSERT IGNORE INTO `set_menu_admin` (`set_menuid`, `mst_adminid`, `view`, `new`, `update`, `delete`, `print`, `export`)
-- SELECT `set_menuid`, 1, 1, 1, 1, 1, 1, 1 FROM `set_menu`;
