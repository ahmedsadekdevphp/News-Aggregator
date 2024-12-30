# Getting started

## Installation

After uncompress project folder you need to do the following 

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Create New database in your Mysql server 

change database name in your .env with all credential


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the database seeder

    php artisan db:seed

Start the local development server

    php artisan serve

Start the larvel queue

    php artisan queue:work
