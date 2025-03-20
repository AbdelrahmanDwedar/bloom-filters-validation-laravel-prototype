# Bloom Filters Validation Laravel Prototype

## Overview

This **prototype** demonstrates how to integrate **Bloom filters** into Laravel's validation system. The goal is to explore the **Bloom filter concept**—a probabilistic data structure used for efficient membership testing—and implement it as part of a **custom validation rule**. This prototype will act as a proof-of-concept to improve database query efficiency for operations similar to Laravel's **`exists`** rule by first checking the filter before querying the database.

---

## ⚠️ Notice

This prototype is created for demonstration purposes on my blog. While the prototype code is specific to my blog implementation, the concept and idea of using Bloom filters in Laravel validation is licensed under Creative Commons Attribution-NonCommercial 4.0 International License (CC BY-NC 4.0). Please refer to the LICENSE file for more details.

---

## Concept

A **Bloom filter** is a space-efficient, probabilistic data structure used to test whether an element is a member of a set. In this prototype:

- **Bloom filter validation** will act as a **pre-check** before querying the database.
- It **reduces unnecessary queries** by quickly determining the likely presence of a value.
- If the **filter returns a positive match**, a **database query** is triggered to confirm the presence of the value.
- If the filter returns **negative**, the query is skipped, improving performance.

---

## Prerequisites

- PHP 8.1 or higher
- Composer
- Redis Stack Server

## Setup and Installation

1. Clone the Repository
```bash
git clone https://github.com/AbdelrahmanDwedar/bloom-filters-validation-laravel-prototype.git
cd laravel-bloom-validation
```

2. Setup Sail (For using docker)
```bash
composer require laravel/sail --dev
php artisan sail:install
```

3. Setup the environment
```bash
cp .env.example .env
./vendor/bin/sail artisan key:generate
```

4. Add the configuration for the database
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=laravel
```

Also, add the configuration for **Redis**
```env
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

5. Start the docker containers, and install dependencies
```bash
./vendor/bin/sail up -d
./vendor/bin/sail composer install
```

6. Use the custom-made commands to prepare the setup
```bash
./vendor/bin/sail artisan benchmark:prepare
./vendor/bin/sail artisan benchmark:perform
```

These are two custom commands I made for this prototype, the first one `benchmark:prepare` task is:
- migrations with a fresh database
- run the seeder

And for the `benchmark:perform` task is to
- run the benchmarks
- display them in a table in the terminal

