-- DDL: FAQ Landing Christmas (section faq.php di invite.php, sekarang dari database)
-- Kompatibel MySQL 5.7 / 8.0 (InnoDB).
-- Kolom audit mengikuti konvensi set_pref; sort_order menentukan urutan tampil.

CREATE TABLE `set_faq` (
  `set_faqid`    INT NOT NULL AUTO_INCREMENT,
  `question`     TEXT NOT NULL,
  `answer`       TEXT NOT NULL,
  `sort_order`   INT NOT NULL DEFAULT 0,
  `suspended`    TINYINT NOT NULL DEFAULT 0,  -- 1 = tidak tampil di landing
  `created_by`   VARCHAR(100) NOT NULL DEFAULT '',
  `created_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by`  VARCHAR(100) NOT NULL DEFAULT '',
  `modified_date` DATETIME NULL,
  PRIMARY KEY (`set_faqid`),
  KEY `xmas_faq_sort_idx` (`sort_order`)
) ENGINE=InnoDB;

-- Seed 6 FAQ (konten yang sebelumnya hardcode di faq.php)
INSERT IGNORE INTO `set_faq` (`set_faqid`, `question`, `answer`, `sort_order`, `suspended`) VALUES
  (1, 'Bagaimana cara melakukan pendaftaran?',
      'Klik tombol "Daftar Sekarang", isi formulir pendaftaran dengan lengkap, lalu tekan tombol kirim. Anda akan menerima konfirmasi melalui kontak yang didaftarkan.', 1, 0),
  (2, 'Apakah acara ini gratis?',
      'Ya, acara ini terbuka untuk umum dan tidak dipungut biaya. Anda hanya perlu mendaftarkan diri untuk menjaga kuota tempat.', 2, 0),
  (3, 'Apakah anak-anak boleh hadir?',
      'Tentu! Anak-anak sangat welcome. Pilih kategori "Anak-anak" saat pendaftaran untuk kelompok usia anak.', 3, 0),
  (4, 'Bagaimana proses check-in?',
      'Datang sesuai sesi yang dipilih, tunjukkan konfirmasi pendaftaran kepada petugas di pintu masuk, lalu Anda akan mendapatkan kartu hadir.', 4, 0),
  (5, 'Apakah perlu membawa tiket?',
      'Tidak perlu tiket fisik. Cukup tunjukkan bukti pendaftaran digital (screenshot atau email konfirmasi) saat check-in.', 5, 0),
  (6, 'Di mana lokasi parkir?',
      'Parkir mobil tersedia di lapangan barat gereja. Parkir motor di halaman gereja. Datang lebih awal untuk mendapatkan tempat parkir yang nyaman.', 6, 0);
