# Installation Guide for cachet

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+ & npm

### Required PHP Extensions

The following PHP extensions must be enabled. On **Windows** these are typically bundled with PHP — just uncomment them in `php.ini`. On **Linux/macOS** you may need to install them separately.

| Extension | Purpose |
|---|---|
| `curl` | HTTP requests (Guzzle, API calls) |
| `fileinfo` | MIME type detection |
| `intl` | Internationalization (dates, numbers, locales) |
| `mbstring` | Multi-byte string handling (UTF-8) |
| `openssl` | SSL/TLS, encryption |
| `pdo_sqlite` | SQLite database driver (PDO) |
| `sqlite3` | SQLite database driver |
| `zip` | ZIP archive handling |
| `xml` | XML parsing (required by Laravel) |

#### Linux / WSL (Ubuntu/Debian)

```bash
# Replace 8.2 with your PHP version (php -v)
sudo apt update && sudo apt install -y \
  php8.2-curl \
  php8.2-intl \
  php8.2-mbstring \
  php8.2-sqlite3 \
  php8.2-xml \
  php8.2-zip
```

> `fileinfo`, `openssl`, and `pdo_sqlite` are typically included with the base PHP package on Linux.

#### macOS (Homebrew)

```bash
# Most extensions are bundled with Homebrew PHP
brew install php
```

#### Windows

Uncomment these lines in your `php.ini`:

```ini
extension=curl
extension=fileinfo
extension=intl
extension=mbstring
extension=openssl
extension=pdo_sqlite
extension=sqlite3
extension=zip
```

## Install

```bash
# 1. Clone the repo
git clone -b uc  https://github.com/United-Codes/cachet-core.git
cd cachet-core

# 2. Install dependencies
composer install
npm install

# 3. Setup & start
composer setup
composer start
```

Open **http://localhost:8000** — status page

Admin panel: **http://localhost:8000/status/dashboard**

Default login: `test@test.com` / `test123`

## Reset

```bash
composer fresh
```

## Common Errors

**"Vite manifest not found"** — Run `npm run build` then `php vendor/bin/testbench vendor:publish --tag=cachet-assets --force`.

**"no such table" error** — Run `php vendor/bin/testbench migrate`.

**"could not find driver" (SQLite)** — Install the SQLite PHP extension. On Linux/WSL: `sudo apt install php8.2-sqlite3` (replace `8.2` with your version).

**Assets look broken** — Run `npm run build` then restart.

**Port 8000 in use** — Kill the process or use `php vendor/bin/testbench serve --port=8080`.
