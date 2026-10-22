-- DDL: Booking Seat (penahan kuota lantai oleh admin)
-- Seat fisik TIDAK ditentukan di sini — hanya jumlah kursi yang ditahan,
-- penentuan seat dilakukan belakangan lewat menu Seating Layout (menu 133).
-- Kompatibel MySQL 5.7 / 8.0 (InnoDB).
-- Prasyarat: 2026-09-27-00001.sql (set_xmas_floor) harus sudah dieksekusi.
-- Rumus sisa kuota setelah tabel ini ada:
--   remaining = capacity - registered - SUM(seats WHERE status = 0)

CREATE TABLE `act_xmas_booking` (
  `bookingid`     BIGINT NOT NULL AUTO_INCREMENT,
  `floor`         TINYINT NOT NULL,
  `seats`         SMALLINT NOT NULL DEFAULT 1,       -- jumlah kursi yang ditahan
  `keterangan`    VARCHAR(255) NOT NULL,             -- alasan/keterangan booking
  `status`        TINYINT NOT NULL DEFAULT 0,        -- 0=aktif (menahan kuota), 1=batal
  `created_by`    INT UNSIGNED NULL,                 -- mst_adminid
  `modified_by`   INT UNSIGNED NULL,
  `created_date`  DATETIME NULL,
  `modified_date` DATETIME NULL,
  PRIMARY KEY (`bookingid`),
  KEY `xmas_booking_floor_idx` (`floor`),
  KEY `xmas_booking_status_idx` (`status`),
  CONSTRAINT `xmas_booking_floor_fk`
    FOREIGN KEY (`floor`) REFERENCES `set_xmas_floor`(`floor`)
) ENGINE=InnoDB;
