##Install

Create empty Mysql database. Set connection to this database in  .env file
- **APP_KEY** - any string;
- **DB_HOST** - database host server (def: 127.0.0.1)
- **DB_PORT** - database port (def: 3306)
- **DB_DATABASE** - database name
- **DB_USERNAME** - database access username
- **DB_PASSWORD** - database access password
- **DB_CONNECTION** - set 'mysql' or empty

Install dependents:
``
composer install
``

I'm using test content/images from DodoPizza UK. Hi, Fedor Ovchinnikov! :)
To crate DB structure & fill this DB with test data use migrations:
``
php artisan migrate
php artisan db:seed
``


