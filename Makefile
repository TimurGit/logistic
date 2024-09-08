# See:
# http://www.gnu.org/software/make/manual/make.html

EXEC_PHP      = docker compose exec php
EXEC_DB       = docker compose exec postgres
EXEC_REDIS    = docker compose exec redis
ARTISAN       = $(EXEC_PHP) php artisan
COMPOSER      = $(EXEC_PHP) composer
DOCKER_F      = docker-compose.yml
DATE          = $(shell date +"%Y-%m-%d")


# This allows us to accept extra arguments
%:
	@:
args = `arg="$(filter-out $@,$(MAKECMDGOALS))" && echo $${arg:-${1}}`

### project setup
rebuild:
	docker compose -f $(DOCKER_F) down --remove-orphans \
	&& docker compose -f $(DOCKER_F) build --parallel \
	&& docker compose -f $(DOCKER_F) up -d \

down:
	docker compose down

up:
	docker compose -f $(DOCKER_F) up -d \

php-shell:
	$(EXEC_PHP) sh

redis-cli:
	$(EXEC_REDIS) sh

optimize:
	$(ARTISAN) optimize

tinker:
	$(ARTISAN) tinker

pint:
	$(EXEC_PHP) ./vendor/bin/pint

artisan-run:
	$(ARTISAN) $(call args,help)

migrate:
	$(ARTISAN) migrate

migrate-rollback:
	$(ARTISAN) migrate:rollback

migration:
	$(ARTISAN) make:migration

composer-install:
	$(COMPOSER) install

# Refresh composer.lock hash
composer-update-hash:
	$(COMPOSER) update --lock

composer-dump-autoload:
	$(COMPOSER) dump-autoload

unittest:
	$(EXEC_PHP) vendor/bin/paratest

reset-roles:
	$(ARTISAN) db:seed --class=RolesAndPermissions

db-seed:
	$(ARTISAN) db:seed
