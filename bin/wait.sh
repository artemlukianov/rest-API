#!/usr/bin/env bash
# wait in dev env while rabbitmq and postgresql will be ready to accept connections
set -e

COMMAND="$1";

while ! nc -z rabbitmq_global 5672;
 do sleep 3;
done

while ! nc -z postgresql 5432;
 do sleep 3;
done

sleep 1;

