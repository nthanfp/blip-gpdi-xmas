-- DDL: Pendaftaran Natal (registration form di invite.php)
-- Kompatibel MySQL 5.7 / 8.0 (InnoDB, utf8 default database)
-- Urutan eksekusi: tabel floor -> registration -> attendee (ada FK).
-- Catatan: tabel baru memakai AUTO_INCREMENT (didukung get_autoid_seq).

-- 1. Kapasitas lantai (sumber "sisa kursi" real-time)
CREATE TABLE `set_xmas_floor` (
  `floor`    TINYINT NOT NULL,
  `name`     VARCHAR(20) NULL,
  `capacity` SMALLINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`floor`)
) ENGINE=InnoDB;

-- 2. Header pendaftaran (1 baris per submit)
CREATE TABLE `act_xmas_registration` (
  `registrationid` BIGINT NOT NULL AUTO_INCREMENT,
  `phone`          VARCHAR(15) NOT NULL,
  `floor`          TINYINT NOT NULL,
  `status`         TINYINT NOT NULL DEFAULT 0,  -- 0=pending, 1=confirmed, 2=cancelled
  `ref_code`       VARCHAR(10) NULL,            -- kode registrasi untuk konfirmasi
  `ip_address`     VARCHAR(200) NULL,
  `ua`             VARCHAR(300) NULL,
  `created_date`   DATETIME(6) NULL,
  PRIMARY KEY (`registrationid`),
  UNIQUE KEY `xmas_registration_ref_uq` (`ref_code`),
  KEY `xmas_registration_phone_idx` (`phone`),
  KEY `xmas_registration_floor_idx` (`floor`),
  CONSTRAINT `xmas_registration_floor_fk`
    FOREIGN KEY (`floor`) REFERENCES `set_xmas_floor`(`floor`)
) ENGINE=InnoDB;

-- 3. Data Jemaat (N baris per registrasi)
CREATE TABLE `act_xmas_attendee` (
  `attendeeid`    BIGINT NOT NULL AUTO_INCREMENT,
  `registrationid` BIGINT NOT NULL,
  `name`          VARCHAR(50) NOT NULL,
  `age`           TINYINT UNSIGNED NOT NULL,     -- 0-120 (validasi di form)
  `is_primary`    TINYINT NOT NULL DEFAULT 0,    -- 1 = baris pertama (pendaftar)
  `created_date`  DATETIME(6) NULL,
  PRIMARY KEY (`attendeeid`),
  KEY `xmas_attendee_registration_idx` (`registrationid`),
  CONSTRAINT `xmas_attendee_registration_fk`
    FOREIGN KEY (`registrationid`) REFERENCES `act_xmas_registration`(`registrationid`)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- Seed kapasitas lantai (angka yang tampil di form: 120 & 85 kursi)
INSERT IGNORE INTO `set_xmas_floor` (`floor`, `name`, `capacity`) VALUES
  (1, 'Lantai 1', 120),
  (2, 'Lantai 2', 85);
