-- Booking Seat: penentuan kursi fisik dari booking (act_xmas_booking)
-- Tambah bookingid di act_seating_seat — kursi reserved khusus booking, bukan attendee.
-- Kompatibel MySQL 5.7 / 8.0 (InnoDB). Aman dijalankan berulang (guard via IF NOT EXISTS logic).

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Kolom bookingid (nullable) + index
ALTER TABLE `act_seating_seat`
  ADD COLUMN `bookingid` BIGINT NULL DEFAULT NULL AFTER `registrationid`,
  ADD KEY `idx_seating_seat_booking` (`bookingid`);

-- 2. FK ke act_xmas_booking (SET NULL — saat booking dihapus, kursi dilepas)
ALTER TABLE `act_seating_seat`
  ADD CONSTRAINT `fk_seating_seat_booking`
    FOREIGN KEY (`bookingid`) REFERENCES `act_xmas_booking` (`bookingid`)
    ON DELETE SET NULL ON UPDATE CASCADE;

SET FOREIGN_KEY_CHECKS = 1;
