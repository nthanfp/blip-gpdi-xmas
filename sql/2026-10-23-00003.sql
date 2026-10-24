-- Invitation landing (landing/invitation/{id}): konfirmasi kehadiran dari undangan.
-- Tambah kolom konfirmasi di act_xmas_booking.
-- Kompatibel MySQL 5.7 / 8.0 (InnoDB).

SET NAMES utf8mb4;

ALTER TABLE `act_xmas_booking`
  ADD COLUMN `confirmed_count` SMALLINT NULL DEFAULT NULL AFTER `status`,
  ADD COLUMN `confirmed_date`  DATETIME NULL DEFAULT NULL AFTER `confirmed_count`;
