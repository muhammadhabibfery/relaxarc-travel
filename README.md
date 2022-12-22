<p align="center">
<img align="center" src="http://ForTheBadge.com/images/badges/built-with-love.svg"> <img align="center" src="http://ForTheBadge.com/images/badges/makes-people-smile.svg"> <img align="center" src="http://ForTheBadge.com/images/badges/built-by-developers.svg">
</p>

# Laravel Travel App Platform

This is a travel app platform I made mostly using Laravel ^8.12

| [Features][] | [Requirements][] | [Install][] | [How to setting][] | [DB Structure][] | [License][] |

## Features 
- |<h3>Menu  </h3>       |       Description                                                                  |
  |-----------------------|-----------------------------------------------------------------------------------|
  |<b>Dashboard           | </b>Contains information about all menu.                                          |
  |<b>Admin               | </b>Manage admin and employee roles.                                              |
  |<b>Travel Package      | </b>Manage all types of travel packages.                                          |
  |<b>Travel Gallery      | </b>Manage images for each type of travel package.                                |
  |<b>Transaction         | </b>Manage transaction for each type of travel package.                           |
  |<b>Profile             | </b>Edit user's profile and password.                                             |
- Travel Platform Solution
- Open Source

## Requirements

	PHP = ^7.3|^8.0
    laravel = ^8.12
    laravel-ui = ^3.2
    intervention/image = ^2.5
    midtrans/midtrans-php = ^2.5

## Install

Clone repo

```
git clone https://github.com/muhammadhabibfery/relaxarc-travel.git
```

Install Composer


[Download Composer](https://getcomposer.org/download/)


composer update/install 

```
composer install
```

Install Nodejs


[Download Node.js](https://nodejs.org/en/download/)


NPM dependencies
```
npm install
```

Using Laravel Mix 

```
npm run dev
```

## How to setting 

Go into .env file change Database and Email credentials.
Then setup the midtrans (Payment Gateway) with your credentials
```
MIDTRANS_SERVER_KEY = <Your-Server-Key>
MIDTRANS_PRODUCTION = false
MIDTRANS_SANITIZED = true
MIDTRANS_3DS = true|false
```

Run the migration

```
php artisan migrate
```

Or run the migration with seeder if you want seeding the related data

```
php artisan migrate --seed
```

Generate a New Application Key

```
php artisan key:generate
```

Create a symbolic link

```
php artisan storage:link
```

## Database Structure
<img src="public/assets/erd.png" alt="Database Structure">


## License

> Copyright (C) 2022 Muhammad Habib Fery.  
**[⬆ back to top](#laravel-travel-app-platform)**

[Features]:#features
[Requirements]:#requirements
[Install]:#install
[How to setting]:#how-to-setting
[DB Structure]:#database-structure
[License]:#license

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
