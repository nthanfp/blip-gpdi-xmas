-- Menu: Pendaftaran Natal -> activities/registration (Registration.php, menuid 120)
-- Jalankan setelah 2026-09-26-00003.sql (unique key set_menu_admin) dan
-- 2026-09-27-00001.sql (tabel act_xmas_registration / act_xmas_attendee / set_xmas_floor).

INSERT IGNORE INTO `set_menu`
  (`set_menuid`, `parent_set_menuid`, `name`, `path`, `suspended`, `order`, `icon`) VALUES
  (120, NULL, 'Pendaftaran Natal', 'activities/registration', 0, 90, 'fas fa-ticket-alt');

-- Grant semua hak ke admin id 1 (aman diulang karena unique key set_menu_admin)
INSERT IGNORE INTO `set_menu_admin`
  (`set_menuid`, `mst_adminid`, `view`, `new`, `update`, `delete`, `print`, `export`) VALUES
  (120, 1, 1, 1, 1, 1, 1, 1);
