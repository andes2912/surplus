## Requirements

* use PHP 8.0 or higher
* Database (eg: MySQL)
* Web Server (eg: Apache, Nginx, IIS)
    
## Framework

Dibangun menggunakan [Laravel](http://laravel.com), the best existing PHP framework, as the foundation framework.

## Installation

* Install [Composer](https://getcomposer.org/download) and [Npm](https://nodejs.org/en/download)
* Clone the repository: `git clone https://github.com/andes2912/surplus.git`
* Install dependencies: `composer install ; npm install ; npm run dev`
* Run `cp .env.example .env` for create .env file
* Run `php artisan migrate --seed` for migration database
* Run `php artisan storage:link` for create folder storage
