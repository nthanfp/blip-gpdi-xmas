-- Perbaikan set_menu_admin:
-- DDL asli (2026-08-20-00006.sql) tidak punya unique key, sehingga
-- INSERT IGNORE di 2026-09-26-00002.sql TIDAK mencegah duplikat
-- (grants bisa terisi 2x -> menu sidebar dobel).
-- Jalankan setelah 2026-09-26-00002.sql.

-- 1. Bersihkan duplikat (pertahankan 1 baris per set_menuid + mst_adminid)
CREATE TEMPORARY TABLE `tmp_set_menu_admin` AS
  SELECT DISTINCT `set_menuid`, `mst_adminid`, `view`, `new`, `update`, `delete`, `print`, `export`
  FROM `set_menu_admin`;

DELETE FROM `set_menu_admin`;

INSERT INTO `set_menu_admin` (`set_menuid`, `mst_adminid`, `view`, `new`, `update`, `delete`, `print`, `export`)
  SELECT `set_menuid`, `mst_adminid`, `view`, `new`, `update`, `delete`, `print`, `export`
  FROM `tmp_set_menu_admin`;

DROP TEMPORARY TABLE `tmp_set_menu_admin`;

-- 2. Unique key agar INSERT IGNORE pada seed jadi idempotent
ALTER TABLE `set_menu_admin`
  ADD UNIQUE KEY `set_menu_admin_unique` (`set_menuid`, `mst_adminid`);
