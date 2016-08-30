.PHONY: test

all: build

build: clean
	docker-compose build

setup: build
	docker-compose run application composer install
	docker-compose run application bin/console doctrine:mongodb:schema:update

init-new: setup
	docker-compose run application bin/console doctrine:mongodb:fixtures:load

setup-production: build
	docker-compose run application composer install -o
	docker-compose run application bin/console doctrine:mongodb:schema:update

run:
	docker-compose up -d

stop:
	docker-compose down

pre-commit:
	docker-compose run application vendor/bin/php-cs-fixer fix --verbose --diff --config-file=.php_cs.php

clean:
	docker-compose rm -f
	rm -rf var/cache/dev
	rm -rf var/cache/prod
	rm -rf var/cache/test

test: run
	docker-compose run application vendor/bin/phpunit

test-debug:
	docker-compose run application vendor/bin/phpunit --stop-on-failure
