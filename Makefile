csfix:
	docker compose exec php vendor/bin/php-cs-fixer fix src

phpunit:
	docker compose exec php bin/phpunit

migrate:
	docker compose exec php bin/console doctrine:migrations:migrate

bash:
	docker compose exec php bash

create-admin:
	docker compose exec php bin/console app:user:create-admin-user

generate-seed-data:
	docker compose exec php bin/console app:generate-data

app-build:
	docker compose build

app-run:
	docker compose up -d

app-stop:
	docker compose downa

generate-keypair:
	docker compose exec php bin/console lexik:jwt:generate-keypair --overwrite --no-interaction

app-deploy:
	docker compose up -d
	docker compose exec php composer install
	docker compose exec php bin/console lexik:jwt:generate-keypair --overwrite --no-interaction
	docker compose exec php bin/console doctrine:database:create
	docker compose exec php bin/console doctrine:migrations:migrate --no-interaction
	docker compose exec php bin/console app:generate-data
	docker compose exec php vendor/bin/php-cs-fixer fix src
	docker compose exec php bin/phpunit
	docker compose exec php bin/console app:user:create-admin-user


