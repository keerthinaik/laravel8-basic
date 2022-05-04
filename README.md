# Steps For Running The Project
clone the project and run the following commands
- composer install
- mv .env.example .env
- php artisan cache:clear
- composer dump-autoload
- php artisan:key generate
- php artisan migrate (run this command only if you are using the database)
- php artisan serve

## Installing Authentication Commands
- composer require laravel/jetstream
- npm install && npm run dev
- php artisan jetstream:install livewire
- php artisan migrate
