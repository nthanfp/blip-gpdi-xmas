-- Menu: Seating Layout (Christmas) — activities/layout
-- Halaman visualisasi denah kursi Lantai 1 & Lantai 2.

INSERT INTO `set_menu` (`set_menuid`, `parent_set_menuid`, `name`, `path`, `icon`, `order`, `suspended`)
VALUES (133, 132, 'Seating Layout', 'activities/layout', 'far fa-circle', 95, 0);

-- Hak akses disamakan dengan menu Registration (set_menuid = 120)
INSERT INTO `set_menu_admin` (`set_menuid`, `mst_adminid`, `view`, `new`, `update`, `delete`, `print`, `export`)
SELECT 133, `mst_adminid`, `view`, `new`, `update`, `delete`, `print`, `export`
FROM `set_menu_admin`
WHERE `set_menuid` = 120;
