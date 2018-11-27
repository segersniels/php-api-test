# php-api-test
1. Start mysql docker container (`cd docker ; docker-compose up`)
2. Run `php init.php` script to initialize the database
3. Run the api by running `composer start` (port: 3000)
4. Execute the Makefile target `make create-order-%` to post a JSON order