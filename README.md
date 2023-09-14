# News Aggregator API [Laravel 10 + Sail]

The project was built with Laravel 10 and Postgres SQL. You can find the React application for this project [here](https://github.com/Luiyit/news-react-app)

Documentation:
- [Laravel](https://laravel.com/docs/10.x/releases)

## Authentication

Authentication was done using JWT token. 
The package to manage the authentication was [jwt-auth](https://jwt-auth.readthedocs.io/en/develop/).

## How to run the project

The project is docked using Laravel Sail. To run the project you must have Docker and Composer installed on your computer.
You can check the Sail documentation [here](https://laravel.com/docs/10.x/sail).

- Open a bash and move to the laravel project folder.
- Copy and paste the .env file for laravel in the rood folder [This file is not included in the repository].
- Run the server `./vendor/bin/sail up`.
- If you want, you can configuring A shell Alias for sail `alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'`. From now we will uso just `sail [options]`.
- In another bash, run the following command to create the database `sail php artisan migrate` and then, run the database seed `sail sail php artisan db:seed`.
- Now you will be able to access to the API in your browser. Open the Browser and access `http://localhost/api/v1/articles`.

## API sources

I'm using three news API. THe New Your Time, News API and The Guardian.
You can find the answer for each service in the `storage/json` folder. The database seed reads these files to populate the database.

