.PHONY: help

CMD ?= ''

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

start:  ## Start the application locally
	@echo "Start the application locally"
	@docker-compose up -d

restart:  ## Restart the application
	@echo "Restart the application"
	@docker-compose restart

stop:  ## Stop the application
	@echo "Stop the application"
	@docker-compose down

clean:  ## Clean the application for Cache and Configurations
	@echo "Cleaning cache, views and configuration compiled the application"
	@docker-compose exec app sh -c "php artisan view:clear && php artisan cache:clear"

optimize:  ## Clean the all application
	@echo "Cleaning all configuration compiled the application"
	@docker-compose exec app sh -c "php artisan optimize"

status:  ## Status the application
	@echo "Status the application"
	@docker-compose ps

logs:	## Show the all Logs from the application
	@echo "Showing all logs for every container"
	@docker-compose logs -f --tail="50"

cli: ## Enter to container console from Laravel
	@echo "Enter to container console from Laravel"
	@docker-compose exec app sh

cli_db: ## Enter to DB container
	@echo "Enter to DB container"
	@docker-compose exec mysql bash

cli_node:	# Enter to Node container
	@echo "Entering to Node container"
	@docker run -ti --rm -v ${PWD}/src:/app -w /app node:latest sh

node_build:	# Build all files from Laravel
	@echo "Building files from Laravel"
	@docker run -ti --rm -v ${PWD}/src:/app -w /app node:latest sh -c "npm run dev"

setup_project:	## Set configuration for development in the project
	@echo "Setting dependencies..."
	@docker-compose up -d
	@cp src/.env.example src/.env
	@docker exec -t backbone_app sh -c "composer  install"
	@docker run -ti --rm -v ${PWD}/src:/app -w /app node:latest sh -c "npm i"
	@echo "Setting the development..."
	@cp pre-commit.sh  .git/hooks/pre-commit
	@chmod +x .git/hooks/pre-commit
	@echo "\033[0;32mThe project was configured successfully, enjoy programming."

phpcs:  ## Analize the code with PHPCS
	@echo "Analizing code..."
	@docker-compose exec app sh -c "php vendor/bin/phpcs --standard=phpcs-laravel  --ignore='*/resources/*,*/public*,*/vendor/*'  --encoding=utf-8 -n -p ."

qa: ## Analize the code for QAS
	@echo "Analizing code...with PHPLINT:"
	@docker-compose exec app sh -c "vendor/bin/phplint"
	@echo "Analizing code...with PHPCS:"
	@docker-compose exec app sh -c "php -d memory_limit=1G vendor/bin/phpcs --standard=phpcs-laravel  --ignore='vendor,phpstan_tmp,resources,storage,tests' --extensions=php --ignore-annotations  --encoding=utf-8 -n -p ."
	@echo "Analizing code...with PHPSTAN:"
	@docker-compose exec app sh -c "php -d memory_limit=1G vendor/bin/phpstan analyze app"