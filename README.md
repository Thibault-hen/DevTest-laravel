# DevTest

This application is a personal project built with Laravel 12 using Inertia.js with Vue.js

This project is a web app for developers to test their knowledges and skills through interactive quizzes.

## Technologies Used

- Laravel 12
- Inertia.js
- Vue.js
- Tailwind CSS
- Postgresql
- Redis
- Docker

## Setup Instructions

### Requirements

- **Option 1 (Full Docker)**: Docker and Docker Compose installed on your device
- **Option 2 (Hybrid - Docker for DB/Redis only)**:
  - Local web server (Herd, WAMP, XAMPP, etc.) with PHP 8.3+
  - PostgreSQL and Redis extensions enabled
  - Composer and Node.js/npm installed
  - Docker and Docker Compose

### Steps

#### Option 1: Using Full Docker Stack

1. Clone the repository:

   ```bash
   git clone git@github.com:Thibault-hen/DevTest-laravel.git
   cd DevTest-laravel
   ```

2. Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

3. Build and run the Docker containers:

   ```bash
   docker compose -f compose.full.yaml up --build
   ```

4. The application will automatically:
   - Install dependencies
   - Generate app key
   - Run migrations
   - Seed the database

5. Access the app at `http://localhost:8000`

#### Option 2: Using Docker for Database & Redis Only (Local Development)

1. Clone the repository:

   ```bash
   git clone git@github.com:Thibault-hen/DevTest-laravel.git
   cd DevTest-laravel
   ```

2. Copy the `.env.example` file to `.env` and update the database and Redis connection settings:

   ```bash
   cp .env.example .env
   ```

   Update the following lines in `.env`:

   ```env
   DB_HOST=127.0.0.1
   DB_PORT=5434

   REDIS_HOST=127.0.0.1
   REDIS_PORT=6379

   VITE_DOCKER=false
   ```

3. Start Docker containers for PostgreSQL and Redis:

   ```bash
   docker compose -f compose.light.yaml up -d
   ```

4. Install PHP and JavaScript dependencies:

   ```bash
   composer install
   npm install
   ```

5. Generate application key and run migrations:

   ```bash
   php artisan key:generate
   php artisan storage:link
   php artisan migrate:fresh --seed
   ```

6. Start the development server:
   - **If using local dev server like Herd, WAMP, XAMPP, etc.**: Access at `configured domain` or `http://localhost:8000`
     ```bash
     npm run dev
     ```
   - **If using built-in PHP server**:
     ```bash
     composer dev
     ```
     Then access at `http://localhost:8000`

---

## Default Credentials

After seeding, you can log in with:

- **Admin**: `admin@example.com` / `password`
- **Regular Users**: Check the database for test users
