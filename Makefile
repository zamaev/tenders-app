## For local machine
build:
	cp .env.example .env
	composer install
	php artisan key:generate
	./vendor/bin/sail up --build 

## For docker machine
chmod:
	chmod -R 777 storage
clear:
	php artisan cache:clear & php artisan config:clear & php artisan cache:clear & php artisan view:cache & php artisan view:clear
# create-controller:
# 	php artisan make:controller MainController
# create-model:
# 	php artisan make:model Tenders -m
# create-migrations:
# 	php artisan make:migration create_api_token_filed
migrate:
	php artisan migrate
