-- Create the laravel_todo schema
CREATE SCHEMA IF NOT EXISTS laravel_todo;

-- Grant privileges to the laravel_user
GRANT ALL PRIVILEGES ON SCHEMA laravel_todo TO laravel_user;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA laravel_todo TO laravel_user;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA laravel_todo TO laravel_user;

-- Set default privileges for future tables
ALTER DEFAULT PRIVILEGES IN SCHEMA laravel_todo GRANT ALL PRIVILEGES ON TABLES TO laravel_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA laravel_todo GRANT ALL PRIVILEGES ON SEQUENCES TO laravel_user;
