-- Booking & Invitation (evolusi Booking Seat):
-- tambah nama undangan & phone (opsional); menu 135 rename menjadi "Booking & Invitation".
-- Kompatibel MySQL 5.7 / 8.0 (InnoDB).

SET NAMES utf8mb4;

ALTER TABLE `act_xmas_booking`
  ADD COLUMN `name`  VARCHAR(100) NOT NULL DEFAULT '' AFTER `seats`,
  ADD COLUMN `phone` VARCHAR(20)  NULL DEFAULT NULL AFTER `name`;

UPDATE `set_menu` SET `name` = 'Booking & Invitation' WHERE `set_menuid` = 135;
