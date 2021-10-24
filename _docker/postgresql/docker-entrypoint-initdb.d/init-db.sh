#!/bin/bash

#MAIN DB
psql -v ON_ERROR_STOP=1 --username postgres <<-EOSQL
CREATE USER rest;
CREATE DATABASE rest_api;
GRANT ALL PRIVILEGES ON DATABASE rest_api TO rest;
EOSQL
psql -v ON_ERROR_STOP=1 --username postgres -d rest_api <<-EOSQL
EOSQL
