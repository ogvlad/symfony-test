# Download and build the latest versions of the images:

docker-compose build --pull --no-cache

# Start Docker Compose in detached mode:

docker-compose up -d

# Entities

## Make entity

php bin/console make:entity

## Make migration

php bin/console make:migration

## Run migration

php bin/console doctrine:migrations:migrate