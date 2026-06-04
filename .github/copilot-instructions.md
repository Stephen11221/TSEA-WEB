# Laravel 12 Project

## Setup Checklist
- [x] Install Laravel 12 framework using Composer
- [x] Install Node.js dependencies with npm
- [ ] Configure .env file with application key
- [ ] Install and configure VS Code extensions
- [ ] Create and run development server tasks
- [ ] Verify database setup

## Project Structure

This is a Laravel 12 web application. Key directories:
- **app/**: Application code (Models, Controllers, Services)
- **routes/**: Route definitions (web.php, api.php)
- **resources/**: Blade templates and frontend assets
- **config/**: Application configuration files
- **database/**: Migrations and seeders
- **storage/**: Logs, cache, and uploaded files
- **tests/**: PHPUnit and feature tests

## Getting Started

### 1. Generate Application Key
The Laravel application key has been generated during installation.

### 2. Start Development Servers
Use VS Code tasks to start the development servers:
- **Laravel Artisan Server**: `php artisan serve`
- **Vite Dev Server**: `npm run dev`

### 3. Database Setup
Configure your database in the .env file, then run:
```bash
php artisan migrate
```

## Development

### Run Laravel Development Server
```bash
php artisan serve
```

### Run Vite Build Server
```bash
npm run dev
```

### Build for Production
```bash
npm run build
```

## Testing
```bash
php artisan test
```

## Required Extensions
- PHP Intelephense (extension: bmewburn.vscode-intelephense-client)
- Laravel Blade Snippets (extension: onecentlin.laravel-blade)
