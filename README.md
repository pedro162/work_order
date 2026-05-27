# Work Order

Laravel 11 API for managing work orders, people, sellers, services, payment methods, and related flows.

## Overview

The project is structured as a Laravel application with clear separation into Application, Domain, Infrastructure, and Http layers. In addition to the API, the repository also includes a frontend base with Vite and Vue for future interface development.

The codebase already includes modules for:

- work orders (`WorkOrder`)
- work order items
- work order installments
- people
- services

## Stack

- PHP 8.2
- Laravel 11
- MySQL 8
- Laravel Passport
- Laravel Sanctum

## Relevant structure

- `app/Application`: use cases, commands, handlers, and services
- `app/Domain`: domain contracts and entities
- `app/Infrastructure`: persistence and Eloquent implementations
- `app/Http`: API controllers, requests, and resources
- `app/Models`: Eloquent models
- `routes`: web, API, and console routes
- `database`: migrations, seeders, and factories

## Current project status

The repository already contains versioned controllers in `app/Http/Controllers/V1`, including resources for work orders, services, sellers, people, payment plans, and payment methods.

However, the routes currently exposed in the code are only:

- `/` returning the default Laravel view
- `/up` as a health check
- `/api/user` protected by Sanctum

In other words, a large part of the application's core domain is already implemented, but the API routes file does not yet expose those versioned endpoints.

## Requirements

- Docker and Docker Compose
- or PHP 8.2+, Composer, and Node.js for local execution without containers

## Running with Docker

The Docker environment defined in the project exposes:

- the application at `http://localhost:9001`
- MySQL at `localhost:3307`

To start the containers:

```bash
docker compose up --build
```

To execute commands inside the application container:

```bash
docker exec -it work_order bash
```

## Local installation

From the project root:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Then adjust the database variables in `.env` according to the environment you want to use.

## Database

`.env.example` uses SQLite by default, but `docker-compose.yml` starts MySQL 8. Choose one of these two scenarios before running migrations.

After configuring the database:

```bash
php artisan migrate
```

If you plan to use OAuth authentication with Passport, you may also need to initialize the keys and clients:

```bash
php artisan passport:install
```

## Frontend development

For local development with Vite:

```bash
npm run dev
```

To generate a production build:

```bash
npm run build
```

## Tests

To run the automated tests:

```bash
php artisan test
```

Or directly with PHPUnit:

```bash
vendor/bin/phpunit
```

## Authentication

The project includes authentication dependencies for Passport and Sanctum.

- `Passport` is configured in `AppServiceProvider` for token expiration
- `Sanctum` already appears in the middleware for the `/api/user` route

Before documenting or consuming protected endpoints, it is worth confirming which authentication strategy will be the official one for the API.

## Important notes

- The previous README described a different application and did not reflect this repository.
- The current project is focused on work orders, not on a standalone `Payment API`.
- There are versioned controllers and services ready for a V1 API, but the public routes still need to be registered in `routes/api.php`.

## License

This project uses the MIT license, as defined in `composer.json`.
