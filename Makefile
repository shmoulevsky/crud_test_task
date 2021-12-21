SHELL=/bin/bash -e

.DEFAULT_GOAL := help

-include ./docker/.env

build: ## Билд проекта
	@cd ./docker && docker-compose build --build-arg UID=$$(id -u) --build-arg GID=$$(id -g)

prepare-app: composer-install key-generate db-fresh ## Первый запуск
	@echo -e "Make: ${PROJECT_NAME} is completed. \n"

up: ## Запуск проекта
	@cd ./docker && docker-compose up --remove-orphans

down: ## Остановка проекта
	@cd ./docker && docker-compose down

restart: down up

bash: ## Доступ к консоли веба
	@cd ./docker && docker exec -it "${PROJECT_NAME}"-php-fpm bash

db-migrate: ## Миграции
	@cd ./docker && docker exec -it --user www-data "${PROJECT_NAME}"-php-fpm php artisan migrate --force

db-seed: ## Сидеры
	@cd ./docker && docker exec -it --user www-data "${PROJECT_NAME}"-php-fpm php artisan db:seed --force

db-fresh: ## Пересборка БД + сидеры
	@cd ./docker && docker exec -it --user www-data "${PROJECT_NAME}"-php-fpm php artisan migrate:fresh --seed --force

composer-install: ## Установка composer
	@cd ./docker && docker exec -it --user www-data "${PROJECT_NAME}"-php-fpm composer install -d /var/www/html

key-generate: ## Генерирование ключа приложения
	@cd ./docker && docker exec -it --user www-data "${PROJECT_NAME}"-php-fpm artisan key:generate

storage-prepare: ## Подготовка storage
	@cd ./docker && docker exec -it --user www-data "${PROJECT_NAME}"-php-fpm chmod a+rw storage -R
	@cd ./docker && docker exec -it --user www-data "${PROJECT_NAME}"-php-fpm php artisan storage:link

clear: ## Сброс всех видов кэшей
	@cd ./docker && docker exec -it --user www-data "${PROJECT_NAME}"-php-fpm php artisan optimize:clear
	@cd ./docker && docker exec -it --user www-data "${PROJECT_NAME}"-php-fpm php artisan config:clear
	@cd ./docker && docker exec -it --user www-data "${PROJECT_NAME}"-php-fpm php artisan route:clear
	@cd ./docker && docker exec -it --user www-data "${PROJECT_NAME}"-php-fpm php artisan event:clear
	@cd ./docker && docker exec -it --user www-data "${PROJECT_NAME}"-php-fpm php artisan view:clear
	@cd ./docker && docker exec -it --user www-data "${PROJECT_NAME}"-php-fpm php artisan cache:clear

default: help
