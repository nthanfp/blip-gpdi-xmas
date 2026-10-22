-- Menu: Booking Seat (Christmas) — activities/booking
-- Ditempatkan sebagai anak dari menu 132 (Christmas), sejajar Registration,
-- Seating Layout & FAQ.
-- Idempotent: INSERT IGNORE (set_menu PK, set_menu_admin UNIQUE KEY).

INSERT IGNORE INTO `set_menu` (`set_menuid`, `parent_set_menuid`, `name`, `path`, `icon`, `order`, `suspended`)
VALUES (135, 132, 'Booking Seat', 'activities/booking', 'far fa-circle', 97, 0);

-- Hak akses disamakan dengan menu Registration (set_menuid = 120)
INSERT IGNORE INTO `set_menu_admin` (`set_menuid`, `mst_adminid`, `view`, `new`, `update`, `delete`, `print`, `export`)
SELECT 135, `mst_adminid`, `view`, `new`, `update`, `delete`, `print`, `export`
FROM `set_menu_admin`
WHERE `set_menuid` = 120;
