# Installation Guide for cachet

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+ & npm

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

## common errros

**"Vite manifest not found"** — Run `npm run build` then `php vendor/bin/testbench vendor:publish --tag=cachet-assets --force`.

**"no such table" error** — Run `php vendor/bin/testbench migrate`.

**Assets look broken** — Run `npm run build` then restart.

**Port 8000 in use** — Kill the process or use `php vendor/bin/testbench serve --port=8080`.
