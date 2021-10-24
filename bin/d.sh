#!/usr/bin/env bash
#docker-compose short commands
# Create alias for dev environment "alias d='sh ./bin/d.sh'"
RED='\033[0;31m'
GREEN='\033[0;32m'
NC='\033[0m'

set -e

COMMAND="$1";

export uid="$(id -u)"
export gid="$(id -g)"

if [ "${COMMAND}" = "bash" ]; then
    printf "${GREEN}BASH${NC} command\n"
    docker-compose exec "$2" bash
elif [ "${COMMAND}" = "install" ]; then
    printf "${GREEN}INSTALL${NC} command\n"
    docker-compose build --no-cache
    docker-compose down --remove-orphans
    docker-compose up -d api
    docker-compose exec -T api bash -c 'composer install --optimize-autoloader --no-interaction'
    docker-compose stop api
elif [ "${COMMAND}" = "logs" ]; then
    printf "${GREEN}LOGS${NC} command\n"
    docker-compose logs -f
elif [ -z "${COMMAND}" ]; then
    printf "${GREEN}HELP${NC} command\n"
    printf "  ${GREEN}bash${NC} - enter into API bash\n"
    printf "  ${GREEN}install${NC} - install dependencies after git clone\n"
    printf "  ${GREEN}logs${NC} - follow docker-compose logs\n"
    printf "  ${GREEN}!command_name!${NC} - docker-compose !command_name!\n"
else
    printf "${GREEN}$COMMAND${NC} command\n"
    docker-compose -f docker-compose.yml ${COMMAND}
fi
