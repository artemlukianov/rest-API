#!/usr/bin/env bash
#project init commend
docker-compose build --no-cache
docker-compose down --remove-orphans
docker-compose up -d
docker-compose exec -T app bash -c 'composer install -o --apcu-autoloader --no-interaction'
docker-compose -f docker-compose.test.pipeline.yml exec -T app bash -c 'while ! nc -z postgresql 5497; do sleep 3; done'
docker-compose exec -T app bash -c 'bin/console doctrine:schema:update --force'