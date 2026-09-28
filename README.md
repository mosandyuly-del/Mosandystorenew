# PulseKu PRO — Laravel 13 PPOB Starter

Starter production-oriented PPOB application for Laravel 13 / PHP 8.3+ with SQLite development support and Railway deployment configuration.

## Important
This repository is a working foundation, not a claim that payment gateway credentials or live Digiflazz production access are configured. Add credentials through environment variables. Verify Digiflazz API parameters/endpoints against the current official documentation before live transactions.

## Local
1. Copy `.env.example` to `.env`.
2. `php artisan key:generate`
3. `php artisan migrate --seed`
4. `php artisan serve`

## Queue
`php artisan queue:work`

## Digiflazz
Configure `DIGIFLAZZ_USERNAME`, development/production key, mode, and endpoint URLs. Use the official documentation: https://id.digiflazz.com/docs

## Railway
Set environment variables in Railway. Recommended production database is PostgreSQL. Run migrations with `php artisan migrate --force`. Run a separate worker service with `php artisan queue:work` for queued Digiflazz processing.
