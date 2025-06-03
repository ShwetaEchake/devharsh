Setup
Clone the Repository:

git clone https://github.com/ShwetaEchake/devharsh.git
cd devharsh

Install Dependencies: Install PHP and Laravel dependencies:
composer install


Set Up Environment Variables:

you can copy .env.example file and create a .env file , also i will share the file via email as well.
update the database credentials in the .env file.
DB_DATABASE=devharsh
QUEUE_CONNECTION=database
OPENAI_API_KEY


Run Migrations: Migrate the database to create necessary tables:
php artisan migrate


Seed the Database::
php artisan db:seed


php artisan serve
