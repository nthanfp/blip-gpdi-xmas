-- Menu: FAQ (Christmas) — activities/faq
-- Ditempatkan sebagai anak dari menu 132 (Christmas), sejajar Registration & Seating Layout.

INSERT INTO `set_menu` (`set_menuid`, `parent_set_menuid`, `name`, `path`, `icon`, `order`, `suspended`)
VALUES (134, 132, 'FAQ', 'activities/faq', 'far fa-circle', 96, 0);

-- Hak akses disamakan dengan menu Registration (set_menuid = 120)
INSERT INTO `set_menu_admin` (`set_menuid`, `mst_adminid`, `view`, `new`, `update`, `delete`, `print`, `export`)
SELECT 134, `mst_adminid`, `view`, `new`, `update`, `delete`, `print`, `export`
FROM `set_menu_admin`
WHERE `set_menuid` = 120;
