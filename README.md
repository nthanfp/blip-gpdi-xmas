# GPDI Christmas — Natal 2026 (blip-gpdi-xmas)

Admin panel for managing Christmas event registration, seating, and booking/invitation at GPDI Koper Permai. Built on CodeIgniter 3 with a dynamic RBAC menu, AdminLTE UI, PDF/XLS print-export, and dashboard recap reporting.

Live: `https://natal.gpdikopopermai.my.id` · Local: `http://localhost/blip-gpdi-xmas`

---

## Tech Stack

| Component | Detail |
|---|---|
| **Framework** | CodeIgniter 3 (PHP 7.4+ / 8.x) |
| **Database** | MySQL (dev + prod via `.env`) |
| **Frontend UI** | AdminLTE 3 (Bootstrap 4), FontAwesome 5, jQuery |
| **PDF Export** | wkhtmltopdf (bundled Windows `.exe` + Linux `wkhtmltopdf.linux` + libs) |
| **Notifications** | Firebase Cloud Messaging (web push), Telegram Bot |
| **E2E Tests** | Playwright (Chromium/Chrome channel) |

---

## Features

### Core (boilerplate)
- **Authentication:** Secure login with database selector, rate limiting, bcrypt hashing, change-password.
- **RBAC:** Sidebar menu driven by `set_menu` / `set_menu_admin`; granular permissions per admin (View, Create, Update, Delete, Print, Export).
- **Admin Management:** CRUD for admin accounts (`Admin`).
- **Preferences:** Key-value store (`Set Pref`) + navigation layout toggle.
- **Logs:** `Log Admin` audit trail; FCM token management; push notification broadcast.
- **Masters:** Region (Province/City/District/Village), FAQ.

### Christmas event modules
- **Dashboard:** Summary cards (capacity, registered, booked, remaining per floor), charts, latest registrations, and **Rekap Data Pendaftaran Natal 2026** table at the bottom — Registration (Jumlah Pendaftar) and Booking & Invitation (per-name seats per floor) sections with bold parents/indented children, separator, then Total Kursi / Total Terisi / Sisa Kursi. Print button → PDF via wkhtmltopdf (`activities/dashboard/data_print`).
- **Registration:** Individual tab (primary attendee list) and Group tab (parent + indented child names; parent keeps phone). Filters: search (phone / ref code / name), floor, status. **Print dropdown:** `Floor 1/2 (Individual)` and `Floor 1/2 (Group)`; titles `Daftar Pendaftaran (Individual|Group) - Lantai 1/2`. Phones shown unmasked in print (no Lantai column — floor lives in the title). **Export to XLS** (Individual only).
- **Booking & Invitation:** Floor quota/seat-hold list with confirmed invitations; responsive table (`text-nowrap` columns, wrapping Name/Notes).
- **Seating Layout:** Floor/row/seat/slot management for the venue.

### Print & Export infrastructure
- `topdf()` in `application/helpers/global_helper.php` streams PDF directly; Windows uses `wkhtmltopdf/wkhtmltopdf.exe`, Linux prefers bundled `wkhtmltopdf.linux` + `LD_LIBRARY_PATH=wkhtmltopdf/lib`, `HOME=/tmp` + fontconfig cache, and passes the session cookie (`--cookie ci3_boiler_admin <id>`) so print pages stay authenticated.
- Shared print views: `application/views/act/act_common_head.php` (title + header row) and `act/common_print.php` (body; `ex=1` → XLS download headers). Styles: `assets/css/style_report.css` (`.tablerep` fixed layout, `.headertd`, `.printjudul`).
- Export/print availability is controlled per menu by `print`/`export` columns in `set_menu_admin` (e.g. Dashboard menu 108, Registration menu 120).

---

## Installation

### Prerequisites
- PHP 7.4+ (works with PHP 8.x), MySQL
- wkhtmltopdf for PDF export — bundled under `./wkhtmltopdf/` (Windows + Linux binaries and libs included)
- Python 3 for `deploy_ftp.py` (production FTP deploy)

### Setup

```bash
cp .env.example .env
# Set DB_* (MySQL), BASE_URL, ENCRYPTION_KEY, SMTP_*, FCM_* as needed
# Import the schema (sql/ contains migration files) into your MySQL database
```

### Environment (`.env` essentials)

```ini
DB_HOST_DEV=localhost
DB_USER_DEV=root
DB_PASS_DEV=
DB_NAME_DEV=
DB_PORT_DEV=3306
# DB_*_PROD for production
BASE_URL=
ENCRYPTION_KEY=
SESSION_COOKIE_NAME=ci3_boiler_admin
TIMEZONE=Asia/Jakarta
NAV_LAYOUT=sidebar          # sidebar | topnav
```

---

## Database Structure

| Table | Purpose |
|---|---|
| `mst_admin` | Admin accounts |
| `set_menu` / `set_menu_admin` | Menu tree + per-admin permissions (view/create/update/delete/print/export) |
| `set_pref` | Key-value app settings |
| `act_log_admin` | Admin action audit log |
| `act_xmas_registration` | Registrations (ref code, phone, floor, status) |
| `act_xmas_attendee` | Attendees per registration (`is_primary` marks parent) |
| `act_xmas_booking` | Booking/invitation holds (floor, name, seats, status) |
| `act_seating_floor` / `_row` / `_seat` / `_slot` | Seating layout |
| `set_xmas_floor` | Floor capacity |
| `mst_reg_province` / `_city` / `_district` / `_village` | Region masters |
| `set_faq`, `act_admin_notifications` | FAQ, notifications |

---

## Directory Structure

```text
├── application/
│   ├── config/                 # Routes, config, autoloads
│   ├── controllers/
│   │   ├── activities/         # Admin modules (Dashboard, Registration, Booking,
│   │   │                       #   Layout, Faq, User, Setmenu, Setpref, Region*,
│   │   │                       #   Notification, Fcmtoken, LogAdmin, Authentication…)
│   │   └── Landing.php         # Public landing
│   ├── helpers/global_helper.php  # topdf(), guards, shared utilities
│   ├── models/                 # *_Model (Registration, Booking, Dashboard, Seating, Telegram…)
│   └── views/
│       ├── activities/         # Module views (dashboard, registration, booking, …)
│       ├── act/                # Print partials (act_common_head, common_print)
│       ├── errors/ partial/    # Error pages, shared layout
│       └── landing/
├── assets/                     # AdminLTE, CSS/JS, style_report.css
├── sql/                        # Dated migration files
├── wkhtmltopdf/                # wkhtmltopdf(.exe/.linux) + lib/ (Linux shared libs)
├── tests/                      # Playwright specs
├── deploy_ftp.py               # FTP deploy (manifest/MD5, --check, skips *.md/.sql/.env)
└── .env                        # Secrets (not committed)
```

---

## Development & Deployment

```bash
# Lint a changed PHP file
C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe -l path/to/file.php

# Deploy preview (what would upload) / actual deploy
python deploy_ftp.py --check
python deploy_ftp.py
```

- `deploy_ftp.py` uploads only changed files (MD5 manifest), applies `SITE CHMOD 755` on Linux, and never deploys `.env`, `*.md`, `*.sql`.
- E2E: Playwright with `chromium.launch({ channel: 'chrome' })`; test login `gpdi` against local or live site.

---

## License

ISC License
