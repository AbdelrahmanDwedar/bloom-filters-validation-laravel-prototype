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
- Redis server
- k6 (for performance testing)

## Setup and Installation

1. Clone the repository:

```bash
git clone https://github.com/yourusername/laravel-bloom-validation.git
cd laravel-bloom-validation
```


2. Install Laravel Sail:

```bash
composer require laravel/sail --dev
php artisan sail:install
```


3. Start Docker containers:

```bash
./vendor/bin/sail up -d
```


4. Install PHP dependencies:

```bash
./vendor/bin/sail composer install
```


5. Set up environment file:

```bash
cp .env.example .env
./vendor/bin/sail artisan key:generate
```

6. Redis is already configured in Sail's Docker environment. Your .env file should have:

```env
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

7. Install k6 for performance testing:

Using Laravel Sail:

./vendor/bin/sail add k6

Alternatively, you can use the k6 Docker image directly:

docker run --rm -i grafana/k6 run - <script.js

Note: When running k6 tests, make sure to use the Docker network to connect to your Laravel application:

./vendor/bin/sail k6 run tests/performance/bloom-filter-validation.js
## Testing

The project includes comprehensive test coverage:

1. Run PHPUnit tests:

php artisan test


2. Run performance tests with k6:

k6 run tests/performance/bloom-filter-validation.js


The test suite includes:
- Unit tests for Bloom filter operations
- Integration tests for validation rules
- Performance benchmarks comparing traditional validation vs Bloom filter validation
