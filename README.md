# ITG QR Tag — INTERNAL QR TAG

Sistem QR Tag untuk produk **Illusions by Internal Grup**. Setiap produk dilengkapi QR code unik yang bisa discan customer untuk mengklaim hadiah (saldo E-Wallet atau Voucher Shopee).

Production: [qrtag.internalgroup.id](https://qrtag.internalgroup.id)

---

## Tech Stack

| Stack | Detail |
|---|---|
| **Framework** | CodeIgniter 3 (PHP 8.x) |
| **Database** | PostgreSQL 16 |
| **Frontend** | jQuery, Bootstrap 4, Tailwind CSS, GSAP, Anime.js, Choices.js, Chart.js |
| **QR Code** | phpqrcode |
| **PWA** | Manifest + Service Worker (Firebase Cloud Messaging) |
| **PDF Export** | wkhtmltopdf |
| **Image Viewer** | Viewer.js |
| **Push Notification** | Firebase Cloud Messaging (FCM) |
| **Captcha** | CodeIgniter Captcha Helper (GD/Imagick) |
| **Assets** | FontAwesome 5 |

---

## Flow QR Tag

```
Admin bulk create voucher
        │
        ▼
Generate QR code per voucher → Cetak QR, tempel pada produk Illusions
        │
        ▼
Customer scan QR code → Landing page (verifikasi voucher)
        │
        ▼
Form klaim (HP, upload bukti, data diri, captcha)
        │
        ▼
Admin review → Confirm atau Reject
        │
        ▼
Hadiah dikirim (E-Wallet / Shopee Voucher)
```

---

## Fitur

### Landing (Customer)

| Halaman | Deskripsi |
|---|---|
| `/landing/{voucher_key}` | Verifikasi voucher — animasi, cek status, redirect ke form klaim |
| `/landing/complete/{voucher_key}` | Form klaim multi-step: nomor HP, upload bukti pembelian, data diri, captcha |
| `/landing/maintenance` | Mode maintenance |
| `/landing/starter` | Coming Soon |

### Admin (Activities)

| Modul | Fitur |
|---|---|
| **Dashboard** | Summary widget, grafik klaim per hari, status pie chart, summary per item |
| **Voucher** | CRUD, bulk create (up to 100k), filter status/item/bulk, QR code download, print/export |
| **Redeem** | Detail redeem, confirm + upload proof, reject + notes, purchase proof viewer, item type filter |
| **Customer** | CRUD dengan hirarki provinsi/kota/kecamatan, geo-filtering |
| **Item Gift** | Atur produk hadiah (E-Wallet / Shopee Voucher), value, suspend |
| **User** | Manajemen admin + permission per menu |
| **Budget** | Monitoring alokasi budget per item, sisa, terdistribusi, expired |
| **Set Menu** | Atur struktur sidebar menu |
| **Set Pref** | Konfigurasi sistem (maintenance mode, dll) |
| **Log Admin** | Riwayat aktivitas admin |
| **Log Email** | Status pengiriman email (send/failed) |
| **FCM Token** | Token push notification perangkat |
| **Sync** | Sinkronisasi file proof antar server |

### API (Publik)

| Endpoint | Fungsi |
|---|---|
| `GET/POST /api/voucher/verification` | Verifikasi voucher key |
| `GET/POST /api/voucher/claim_gift` | Klaim hadiah (captcha + file upload) |
| `GET /api/voucher/captcha` | Generate captcha image |
| `GET/POST /api/customer/check_phone` | Cek nomor HP customer |
| `GET/POST /api/code/verify` | Verifikasi voucher code (alternatif) |
| `GET/POST /api/code/claim` | Klaim voucher code (alternatif) |

---

## Database

### Tabel Utama

| Tabel | Fungsi |
|---|---|
| `mst_voucher` | Master voucher (status 1-5, voucher_key HMAC, bulk_code) |
| `mst_itemgift` | Master produk hadiah (type: 1=E-Wallet, 2=Shopee) |
| `mst_customer` | Data customer (nama, HP, email, region) |
| `act_redeem` | Transaksi klaim (customer, voucher, geo, status timeline) |
| `act_redeem_purchase_proof` | Bukti pembelian dari customer |
| `act_redeem_proof` | Bukti delivery dari admin |
| `act_email_log` | Riwayat email |
| `act_log_admin` | Log aktivitas admin |
| `act_admin_notifications` | Notifikasi in-app |
| `act_admin_fcm_tokens` | Token FCM perangkat |
| `mst_admin` | User admin |
| `set_menu` | Struktur menu sidebar |
| `set_menu_admin` | Permission per menu per admin |
| `set_pref` | Konfigurasi sistem key-value |

---

## Status Voucher

| Status | Label | Keterangan |
|---|---|---|
| 1 | CREATED | Siap, QR belum dicetak |
| 2 | PRINTED | QR sudah dicetak, siap ditempel pada produk |
| 3 | REDEEMED | Customer scan & klaim, menunggu konfirmasi admin |
| 4 | COMPLETED | Admin konfirmasi, hadiah dikirim |
| 5 | REJECTED | Admin tolak |

**Shopee Voucher (type=2)**: Auto-complete — status langsung 1 → 4.
**E-Wallet (type=1)**: Perlu admin konfirmasi — 1 → 3 → 4.

---

## Instalasi

### Prasyarat

- PHP 8.x
- PostgreSQL 16
- Composer
- wkhtmltopdf (untuk export PDF)
- Node.js (untuk Tailwind CSS)

### Setup

```bash
# Clone repo
git clone https://github.com/nthanfp/itg-gift.git

# Copy .env
cp .env.example .env
# Sesuaikan DB credentials di .env

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Build Tailwind CSS
npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind.css

# Setup database
# Buat database PostgreSQL, jalankan migration

# Cek wkhtmltopdf tersedia di ./wkhtmltopdf/
# Untuk Linux/Mac, download dari https://wkhtmltopdf.org/downloads.html
```

### Konfigurasi Environment

```
DB_HOST_DEV=localhost
DB_USER_DEV=postgres
DB_PASS_DEV=your_password
DB_NAME_DEV=itg_qrtag
DB_PORT_DEV=5434

DB_HOST_PROD=localhost
DB_USER_PROD=postgres
DB_PASS_PROD=your_prod_password
DB_NAME_PROD=itg_qrtag
DB_PORT_PROD=5432

SMTP_HOST=smtp.internalgroup.id
SMTP_PORT=587
SMTP_USER=noreply@internalgroup.id
SMTP_PASS=your_smtp_password

ENCRYPTION_KEY=your_32_char_key
SESSION_COOKIE_NAME=itg_qrtag_session
EMAIL_FROM_NAME=Hoki Beli Illusions
```

---

## Keamanan

| Aspek | Status |
|---|---|
| CSRF Protection | ✅ Enabled (kecuali API endpoint tertentu) |
| Session | File-based, regenerate tiap 300 detik |
| Password | Bcrypt hash |
| Menu Permission | Per admin + sub-permission (view/new/update/delete/print/export) |
| Input Validation | Server-side + client-side |
| File Upload | Validasi MIME, magic bytes, extension, kompresi gambar |
| QR Key | HMAC-signed voucher keys |
| Rate Limiting | 20 request/min/IP pada verification API |

### Issues yang sudah difix

- Race condition double-claim — `FOR UPDATE OF v` + guarded update
- Status bypass — `data_update()` tidak bisa edit status voucher
- Confirm/reject race — row locking + status pre-condition
- HMAC secret — pindah ke environment variable
- Redeem data_update lifecycle fields — hanya editable lewat flow aksi

---

## Struktur

```
├── application/
│   ├── config/              # Database, config, routes
│   ├── controllers/
│   │   ├── activities/      # Admin controllers
│   │   ├── api/             # Public API (Voucher, Customer, Code)
│   │   └── Landing.php      # Landing page controller
│   ├── helpers/             # Global helper + topdf()
│   ├── hooks/               # Security headers
│   ├── models/              # Model files
│   ├── views/
│   │   ├── activities/      # Admin pages
│   │   ├── landing/         # Customer pages (scan QR → klaim)
│   │   ├── partial/         # Shared templates (sidebar, navbar, etc.)
│   │   └── act/             # Print/export templates
│   └── third_party/         # phpqrcode
├── assets/                  # CSS, JS, images, plugins
├── env/                     # Firebase service account
├── system/                  # CodeIgniter 3 framework
├── uploads/                 # Purchase proof, redeem proof
├── wkhtmltopdf/             # PDF export binary
├── .env                     # Environment config
├── firebase-config.js       # Firebase SDK config
├── firebase-messaging-sw.js # Service Worker (FCM + caching)
└── manifest.json            # PWA manifest
```

---

## Development

```bash
# Build CSS
npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind.css --watch

# Run tests
npx playwright test

# Check PHP syntax
php -l application/models/*.php
php -l application/controllers/**/*.php
```

---

## License

ISC License — see [package.json](package.json)
