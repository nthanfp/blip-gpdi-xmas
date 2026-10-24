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

-- Seed 7 FAQ (diselaraskan dengan info di landing page: tanggal, waktu, lokasi, dresscode, kode registrasi, pilih lantai)
INSERT IGNORE INTO `set_faq` (`set_faqid`, `question`, `answer`, `sort_order`, `suspended`) VALUES
  (1, 'Kapan dan di mana acara dilaksanakan?',
      'Minggu, 20 Desember 2026 pukul 17.00 - 20.00 WIB (open gate 16.00 WIB) di GPdI Kopo Permai, Komp. Kopo Permai 2 Blok 19B No. 2-4, Bandung.', 1, 0),
  (2, 'Apakah acara ini gratis?',
      'Ya, acara Natal ini terbuka untuk umum dan tidak dipungut biaya. Anda hanya perlu mendaftarkan diri karena tempat dibatasi sesuai kuota.', 2, 0),
  (3, 'Bagaimana cara melakukan pendaftaran?',
      'Klik tombol "Daftar Sekarang", isi nomor HP beserta nama dan umur setiap peserta, pilih lantai (Lantai 1 / Lantai 2), lalu kirim. Kode registrasi akan langsung muncul di layar - simpan screenshot-nya.', 3, 0),
  (4, 'Apakah anak-anak boleh hadir?',
      'Tentu! Anak-anak sangat welcome. Cukup tambahkan nama dan umur anak Anda sebagai peserta saat pendaftaran.', 4, 0),
  (5, 'Apa yang perlu ditunjukkan saat check-in?',
      'Tidak perlu tiket fisik. Cukup tunjukkan kode registrasi (dari screenshot pendaftaran) kepada petugas di pintu masuk mulai pukul 16.00 WIB.', 5, 0),
  (6, 'Apakah ada dresscode?',
      'Dresscode acara adalah Merah / Gold. Kenakan busana dengan nuansa merah atau emas sesuai tema Natal.', 6, 0),
  (7, 'Di mana lokasi parkir?',
      'Parkir mobil tersedia di lapangan barat gereja. Parkir motor di halaman gereja. Datang lebih awal untuk mendapatkan tempat parkir yang nyaman.', 7, 0);
