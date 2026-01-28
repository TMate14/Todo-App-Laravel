# Laravel Todo Application - Docker Setup

This Docker setup allows you to run your Laravel todo application locally without installing PHP, Node.js, or PostgreSQL on your machine.

## Prerequisites

- Docker
- Docker Compose

## Setup Instructions

### 1. Prepare Your Environment File

Copy the example environment file and generate an application key:

```bash
# Copy the environment file
cp .env.example .env

# The containers will handle the rest, but you can customize .env if needed
```

### 2. Build and Start the Containers

```bash
# Build and start all containers
docker-compose up -d

# This will:
# - Build the Laravel application image
# - Start PostgreSQL database
# - Install PHP dependencies (Composer)
# - Install Node dependencies and build assets
# - Start Apache web server
```

### 3. Generate Application Key

```bash
# Generate Laravel application key
docker-compose exec app php artisan key:generate
```

### 4. Run Database Migrations

```bash
# Run migrations to create tables in the laravel_todo schema
docker-compose exec app php artisan migrate
```

### 5. Access the Application

Open your browser and navigate to:
```
http://localhost:8000
```

## Common Commands

### View Logs
```bash
# View all logs
docker-compose logs -f

# View app logs only
docker-compose logs -f app

# View database logs only
docker-compose logs -f db
```

### Run Artisan Commands
```bash
# General format
docker-compose exec app php artisan <command>

# Examples:
docker-compose exec app php artisan migrate
docker-compose exec app php artisan migrate:rollback
docker-compose exec app php artisan tinker
docker-compose exec app php artisan route:list
```

### Access the Database
```bash
# Connect to PostgreSQL
docker-compose exec db psql -U laravel_user -d laravel_todo

# Or from your host machine (if you have psql installed)
psql -h localhost -U laravel_user -d laravel_todo
# Password: laravel_password
```

### Rebuild Assets (if you modify frontend code)
```bash
docker-compose exec app npm run build
```

### Stop the Application
```bash
# Stop containers
docker-compose down

# Stop and remove volumes (WARNING: This deletes your database data)
docker-compose down -v
```

### Restart the Application
```bash
# Restart all services
docker-compose restart

# Restart specific service
docker-compose restart app
```

## Troubleshooting

### Permission Issues
If you encounter permission errors with storage or cache:

```bash
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/bootstrap/cache
```

### Clear Cache
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Rebuild Containers
If you make changes to Dockerfile or need a fresh start:

```bash
# Rebuild and restart
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### Database Connection Issues
Make sure the schema is set correctly in your `.env` file:

```
DB_SCHEMA=laravel_todo
```

If migrations fail, you can manually create the schema:

```bash
docker-compose exec db psql -U laravel_user -d laravel_todo -c "CREATE SCHEMA IF NOT EXISTS laravel_todo;"
```

## Testing

Since you mentioned you want to practice software testing, here are some useful commands:

```bash
# Run PHPUnit tests
docker-compose exec app php artisan test

# Or with PHPUnit directly
docker-compose exec app ./vendor/bin/phpunit
```

## Database Information

- **Host**: localhost (from your machine) or `db` (from within containers)
- **Port**: 5432
- **Database**: laravel_todo
- **Schema**: laravel_todo
- **Username**: laravel_user
- **Password**: laravel_password

## File Structure

```
.
├── Dockerfile              # PHP/Laravel container configuration
├── docker-compose.yml      # Multi-container orchestration
├── init-db.sql            # PostgreSQL schema initialization
├── .env.example           # Environment variables template
├── .dockerignore          # Files to exclude from Docker build
└── README-DOCKER.md       # This file
```

## Notes

- The application runs on port 8000 (http://localhost:8000)
- PostgreSQL runs on port 5432
- All your Laravel code changes are reflected immediately (volume mounted)
- Database data persists in a Docker volume named `postgres_data`
- First build might take a few minutes as it downloads images and installs dependencies

### Post notes:
I had to run the following commands before actually reaching the app:
- docker-compose exec app composer install
- docker-compose exec app php artisan key:generate
- docker-compose exec app php artisan migrate

Then the following commands to build the frontend:
- docker-compose exec app npm install # Install node dependencies first
- docker-compose exec app npm run build # Then build
