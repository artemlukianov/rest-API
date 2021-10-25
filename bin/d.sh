#!/usr/bin/env bash
set -e

COMMAND="$1";

if [ "${COMMAND}" = "bash" ]; then
    docker-compose exec "$2" bash
elif [ "${COMMAND}" = "install" ]; then
    docker-compose build --no-cache
    docker-compose down --remove-orphans
    docker-compose up -d app
    docker-compose exec -T app bash -c 'composer install -o --apcu-autoloader --no-interaction'
    docker-compose stop app
elif [ "${COMMAND}" = "logs" ]; then
    docker-compose logs -f
else
    printf "${GREEN}$COMMAND${NC} command\n"
    docker-compose -f docker-compose.yml ${COMMAND}
fi
