# Command
reload: ticket-reload ticket-comment-load ticket-post-load

user-load:
	php application.php user:load
user-delete:
	php application.php user:delete
ticket-load:
	php application.php ticket:load
ticket-delete:
	php application.php ticket:delete
ticket-reload: ticket-delete ticket-load

ticket-post-load:
	php application.php ticket-post:load

ticket-comment-load:
	php application.php ticket-comment:load

ctest:
	php application.php test
# Service
test:
	./composer test

# Develop
init: docker-down-clear docker-pull docker-build docker-up
up: docker-up
down: docker-down
restart: down up

docker-up:
	docker compose up -d
docker-down:
	docker compose down --remove-orphans
docker-down-clear:
	docker compose down -v --remove-orphans
docker-pull:
	docker compose pull
docker-build:
	docker compose build --pull

# Static analysis

lint:
	./vendor/bin/phplint
fix:
	./vendor/bin/php-cs-fixer fix src
psalm:
	./vendor/bin/psalm

