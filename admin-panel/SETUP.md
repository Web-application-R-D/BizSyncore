# BizSyncore Admin Panel — Setup & Run Guide

## Prerequisites

- [Homebrew](https://brew.sh/) (macOS package manager)
- Node.js & npm

---

## 1. Install PHP & Composer

```bash
brew install php
brew install composer
```

> PHP 8.5+ is required. XAMPP's bundled PHP (8.2) is not compatible.

---

## 2. Install Dependencies

```bash
# PHP dependencies
composer install

# JavaScript dependencies
npm install
```

---

## 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

---

## 4. Database Setup

The project uses SQLite by default. Run migrations to create the database:

```bash
php artisan migrate
```

---

## 5. Fix PHP 8.5 Deprecation Warning (one-time)

Laravel's vendor config uses a deprecated PDO constant in PHP 8.5. After `composer install`, apply this fix:

In `vendor/laravel/framework/config/database.php`, add `use Pdo\Mysql;` at the top and replace both occurrences of:

```php
PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
```

with:

```php
(PHP_VERSION_ID >= 80500 ? Mysql::ATTR_SSL_CA : PDO::MYSQL_ATTR_SSL_CA) => env('MYSQL_ATTR_SSL_CA'),
```

> This fix must be reapplied after every `composer update`.

---

## 6. Start the Development Servers

Open **two terminal tabs** and run each command in a separate tab:

**Tab 1 — Laravel backend (http://127.0.0.1:8000):**
```bash
php artisan serve
```

**Tab 2 — Vite frontend (http://localhost:5173):**
```bash
npm run dev
```

Then open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

---

## 7. Stop the Servers

Press `Ctrl+C` in each terminal tab to stop the servers.

---

## Useful Commands

| Command | Description |
|---|---|
| `php artisan migrate` | Run database migrations |
| `php artisan migrate:fresh` | Drop all tables and re-run migrations |
| `php artisan config:clear` | Clear configuration cache |
| `php artisan cache:clear` | Clear application cache |
| `php artisan route:list` | List all registered routes |
| `npm run build` | Build frontend assets for production |
