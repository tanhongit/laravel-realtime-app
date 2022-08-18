# laravel-realtime-app

# 1. Technology
- PHP 8.1
- Laravel Framework 9.x

# 2. Configuration requirements
- Install composer: https://getcomposer.org/

# 3. Running

## Clone repo

```bash
git clone https://github.com/TanHongIT/laravel-training-module
cd laravel-training-module/blog
```

## Install Composer & npm for project

Run:

```bash
npm install
composer install
```

## Create APP_KEY

Run:

```
cp .env.example .env
php artisan key:generate
```

## Create a new database in your host & edit .env

Create a new database in your server and edit the information in the .env file

```laravel
DB_CONNECTION=mysql
DB_HOST=172.24.0.2
DB_PORT=3306
DB_DATABASE=realtime-app
DB_USERNAME=root
DB_PASSWORD=root
```

> Don't forget to change __APP_URL__ on *.env* file for your app.

## Migrate Database

Run:

```bash
php artisan migrate
```

## Launch project
Now, Launch your system...

Run: 

```bash
npm run dev
```

Also create a new terminal tab and run:

```bash
node server.js
```
