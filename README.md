# CI3 Boilerplate Admin

A clean, robust CodeIgniter 3 boilerplate for kickstarting admin panels and backend systems. Features a dynamic RBAC menu, modular architecture, and modern UI out of the box.

---

## Tech Stack

| Component | Detail |
|---|---|
| **Framework** | CodeIgniter 3 (PHP 7.0+ / 8.x compatible) |
| **Database** | PostgreSQL |
| **Frontend UI** | AdminLTE 3 (Bootstrap 4) |
| **Icons** | FontAwesome 5 |
| **Data Tables** | DataTables (jQuery) |
| **PDF Export** | wkhtmltopdf |

---

## Core Features

- **Authentication:** Secure login with rate limiting and bcrypt password hashing.
- **Role-Based Access Control (RBAC):** Dynamic sidebar menu driven by database. Permissions granularly controlled per admin user (View, Create, Update, Delete, Print, Export).
- **Admin Management:** CRUD for admin accounts.
- **System Preferences:** Key-value store for global settings (e.g., Maintenance Mode).
- **Activity Logs:** Automatic logging of admin actions (`Log Admin`) and API requests (`Log API`).
- **API Key Management:** Generate and manage API keys for external integrations.

---

## Installation

### Prerequisites

- PHP 7.0+ (Works with PHP 8.x)
- PostgreSQL
- wkhtmltopdf (For PDF exports, place binary in `./wkhtmltopdf/`)

### Setup

```bash
# Clone the repository
git clone https://github.com/yourusername/ci3-boiler-admin.git
cd ci3-boiler-admin

# Setup Environment
cp .env.example .env
# Edit .env with your database credentials

# Setup Database
# Create a PostgreSQL database and import the starting schema (if available)
```

### Environment Configuration (`.env`)

```ini
DB_HOST_DEV=localhost
DB_USER_DEV=postgres
DB_PASS_DEV=secret
DB_NAME_DEV=ci3_admin_db
DB_PORT_DEV=5432

# Production settings
DB_HOST_PROD=localhost
DB_USER_PROD=postgres
DB_PASS_PROD=secret_prod
DB_NAME_PROD=ci3_admin_db
DB_PORT_PROD=5432

ENCRYPTION_KEY=your_32_char_random_string_here
SESSION_COOKIE_NAME=ci3_admin_session
```

---

## Database Structure

### Core Tables

| Table | Purpose |
|---|---|
| `mst_admin` | Admin user accounts |
| `set_menu` | Defines the sidebar menu structure (parent/child relationships) |
| `set_menu_admin` | Junction table assigning menus and granular permissions to admins |
| `set_pref` | Key-value configuration store |
| `act_log_admin` | Audit trail of admin user actions |

---

## Directory Structure

```text
├── application/
│   ├── config/              # Routes, constants, config
│   ├── controllers/
│   │   ├── activities/      # Admin Panel Controllers (Dashboard, User, LogAdmin, etc.)
│   │   ├── api/             # API Controllers
│   │   └── Landing.php      # Public starter page
│   ├── helpers/             # Custom helpers
│   ├── models/              # Database models
│   └── views/
│       ├── activities/      # Admin Panel views
│       ├── errors/          # Custom 404, 500 error pages
│       ├── landing/         # Public starter views
│       └── partial/         # Shared UI partials (header, footer, sidebar)
├── assets/                  # CSS, JS, AdminLTE plugins
├── uploads/                 # File upload directory
├── wkhtmltopdf/             # Place wkhtmltopdf binary here
└── .env                     # Environment variables (do not commit)
```

---

## License

ISC License
