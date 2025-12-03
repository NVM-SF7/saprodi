# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

SAPRODI is a Laravel 12 e-commerce product catalog and management application. It features a public-facing product catalog with search and pagination, and an admin dashboard for managing products, categories, units, and featured items.

**Tech Stack:** Laravel 12, PHP 8.2+, MySQL, Tailwind CSS v3, Alpine.js v3, Vite, Pest PHP

## Common Commands

```bash
# Development server (runs Laravel, queue worker, and Vite concurrently)
composer run-script dev

# Run tests
composer run-script test
php artisan test

# Frontend asset build
npm run dev          # Development with hot reload
npm run build        # Production build

# Database
php artisan migrate
php artisan db:seed

# Code formatting
./vendor/bin/pint
```

## Architecture

### Domain Structure

The application manages these core entities:
- **Barang** (Products) - Main entity with photo, name, detail, price, category, unit, and recommendation status
- **JenisBarang** (Categories) - Product categories
- **Satuan** (Units) - Units of measurement (e.g., kg, pcs)
- **BestSell** - Featured products system (max 3 products)
- **Setting** - Key-value application settings

### Route Organization

**Public routes** (unauthenticated):
- `/` - Landing page with featured products
- `/katalog` - Product catalog with search and pagination
- `/produk/{id}` - Product detail page

**Admin routes** (authenticated, `auth` middleware):
- `/dashboard` - Admin dashboard
- Resource routes: `jenis_barang`, `satuan`, `barang`, `best_sell`
- `/barang/update-bulk-rekomendasi` - Bulk update featured products

### Model Relationships

```
Barang belongsTo JenisBarang (via id_jenis)
Barang belongsTo Satuan (via id_satuan)
JenisBarang hasMany Barang
Satuan hasMany Barang
```

### View Structure

- `resources/views/admin/` - Admin panel views (CRUD for products, categories, units, featured items)
- `resources/views/public/` - Public-facing views (landing, catalog, product detail)
- `resources/views/components/admin/` - Admin components (navigation, tables, alerts)
- `resources/views/components/public/` - Public components (nav, footer)
- `resources/views/layouts/` - Layout templates

### File Storage

Product images are stored in `storage/app/public/barang/` and accessed via the `public/storage` symlink. Run `php artisan storage:link` if the symlink is missing.

## Key Business Rules

- Featured products (rekomendasi) are limited to a maximum of 3 items
- Product images are nullable and old images are deleted when updated
- Foreign keys use `onDelete('set null')` to preserve products when categories/units are deleted

## Testing

Tests use Pest PHP with SQLite in-memory database. Configuration is in `phpunit.xml`.

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ExampleTest.php
```

## Naming Conventions

- Controllers: Singular (BarangController, JenisBarangController)
- Models: Singular (Barang, JenisBarang, Satuan)
- Database tables: snake_case (jenis_barang, barang)
- Routes: snake_case resources (jenis_barang, best_sell)
