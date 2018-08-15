install:
	composer install

test:
	composer run-script phpunit tests

run:
	php -S localhost:8000 -t public

lint:
	composer run-script phpcs -- --standard=PSR2 --extensions=php routes tests app
