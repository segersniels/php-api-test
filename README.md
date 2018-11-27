# php-api-test
1. start mysql docker container (`cd docker ; docker-compose up`)
2. run `php init.php` script to initialize the database
3. execute the Makefile target `make create-order-%` to post a JSON order