# File: Makefile
.PHONY: help build up down restart logs shell test migrate seed fresh install

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Available targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-15s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build Docker containers
	docker-compose build

up: ## Start all containers
	docker-compose up -d

down: ## Stop all containers
	docker-compose down

restart: ## Restart all containers
	docker-compose restart

logs: ## View logs from all containers
	docker-compose logs -f

logs-php: ## View PHP container logs
	docker-compose logs -f php

logs-nginx: ## View Nginx container logs
	docker-compose logs -f nginx

logs-mysql: ## View MySQL container logs
	docker-compose logs -f mysql

logs-postgres: ## View PostgreSQL container logs
	docker-compose logs -f postgres

logs-mongodb: ## View MongoDB container logs
	docker-compose logs -f mongodb

logs-queue: ## View Queue worker logs
	docker-compose logs -f queue

shell: ## Access PHP container shell
	docker-compose exec php sh

shell-mysql: ## Access MySQL shell
	docker-compose exec mysql mysql -u${DB_USERNAME} -p${DB_PASSWORD} ${DB_DATABASE}

shell-postgres: ## Access PostgreSQL shell
	docker-compose exec postgres psql -U ${PGSQL_USERNAME} -d ${PGSQL_DATABASE}

shell-mongodb: ## Access MongoDB shell
	docker-compose exec mongodb mongosh -u ${MONGO_USERNAME} -p ${MONGO_PASSWORD} --authenticationDatabase admin

shell-redis: ## Access Redis CLI
	docker-compose exec redis redis-cli

install: ## Install PHP dependencies
	docker-compose exec php composer install

migrate: ## Run database migrations
	docker-compose exec php php artisan migrate

migrate-fresh: ## Fresh migrations (WARNING: drops all tables)
	docker-compose exec php php artisan migrate:fresh

seed: ## Run database seeders
	docker-compose exec php php artisan db:seed

fresh: ## Fresh migrations with seeders
	docker-compose exec php php artisan migrate:fresh --seed

test: ## Run tests
	docker-compose exec php php artisan test

test-coverage: ## Run tests with coverage
	docker-compose exec php php artisan test --coverage

optimize: ## Optimize application
	docker-compose exec php php artisan optimize
	docker-compose exec php php artisan config:cache
	docker-compose exec php php artisan route:cache
	docker-compose exec php php artisan view:cache

clear: ## Clear all caches
	docker-compose exec php php artisan optimize:clear
	docker-compose exec php php artisan config:clear
	docker-compose exec php php artisan route:clear
	docker-compose exec php php artisan view:clear
	docker-compose exec php php artisan cache:clear

queue-work: ## Start queue worker (foreground)
	docker-compose exec php php artisan queue:work --verbose

queue-restart: ## Restart queue workers
	docker-compose exec php php artisan queue:restart

stats: ## Show Docker container stats
	docker stats

ps: ## Show running containers
	docker-compose ps

clean: ## Remove all containers, volumes, and images
	docker-compose down -v --rmi all --remove-orphans

setup: build up install migrate seed ## Complete setup from scratch
	@echo "Setup complete! Access the application at http://localhost:8000"
	@echo "MailHog UI available at http://localhost:8025"
