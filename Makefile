## For local machine
build:
	cp .env.example .env
	composer install
	php artisan key:generate
	./vendor/bin/sail up --build
start:
	./vendor/bin/sail up

## For docker machine
chmod:
	chmod -R 777 storage
clear:
	php artisan cache:clear & php artisan config:clear & php artisan cache:clear & php artisan view:cache & php artisan view:clear
# create-controller:
# 	php artisan make:controller MainController
create-model:
	php artisan make:model Statuses
# php artisan make:model Tenders -m
# create-migration:
# 	php artisan make:migration create_statuses_table
migrate:
	php artisan migrate
# api-controller:
# 	php artisan make:controller Api\\TendersController --model=Tenders
# api-request:
# 	php artisan make:request IndexTendersRequest
#php artisan make:request StoreTendersRequest
