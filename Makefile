FIG=docker-compose
OS := $(shell uname -s 2>/dev/null || echo Windows)

# Détection de Docker Compose sur Windows et Linux/macOS
ifeq ($(OS), Windows)
  HAS_DOCKER := $(shell where docker-compose 2>nul)
else
  HAS_DOCKER := $(shell command -v $(FIG) 2>/dev/null)
endif

ifdef HAS_DOCKER
  EXEC=$(FIG) exec app
  EXEC_DB=$(FIG) exec db
else
  $(warning "Warning: Docker Compose is not installed or not found in PATH. Some commands may not work.")
  EXEC=
  EXEC_DB=
endif

# Symfony commands
CONSOLE=php bin/console

# Docker controls
start: ## Start Docker containers
	$(FIG) up -d

stop: ## Stop Docker containers
	$(FIG) down

restart: stop start ## Restart Docker containers

update: ## Install composer dependencies
	$(EXEC) composer install

upgrade: ## Update composer dependencies
	$(EXEC) composer update

# ================ #
#      Entity      #
# ================ #
validate: ## Validate Schema
	$(EXEC) $(CONSOLE) doctrine:schema:validate
schema_update: ## Update Schemas
	$(EXEC) $(CONSOLE) doctrine:schema:update --force --dump-sql
create_database: ## Create a new Database
	$(EXEC) $(CONSOLE) d:d:c --if-not-exists
entity: ## Create a new Symfony entity
	$(EXEC) $(CONSOLE) make:entity
user: ## Create a new Symfony entity
	$(EXEC) $(CONSOLE) make:user


test_email:
	$(EXEC) $(CONSOLE) mailer:test someone@example.com

# Help target without grep/awk (cross-platform solution)
help: ## Display this help message
	@echo "Available commands:"
	@echo ""
	@echo "  start   	Start Docker containers"
	@echo "  stop    	Stop Docker containers"
	@echo "  restart 	Restart Docker containers"
	@echo "  update  	Install composer dependencies"
	@echo "  upgrade 	Update composer dependencies"
	@echo "  create_database      Create a new Database"
	@echo "  entity  	Create a new Symfony entity"
	@echo "  help    	Display this help message"
