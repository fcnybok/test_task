install:
	@docker-compose build
	@docker-compose up --detach
	@docker-compose run --rm php composer install
	@docker-compose run --rm php php bin/console doctrine:database:drop --if-exists --force
	@docker-compose run --rm php php bin/console doctrine:database:create --if-not-exists
	@docker-compose run --rm php php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
	@docker-compose run --rm php php bin/console doctrine:fixtures:load
