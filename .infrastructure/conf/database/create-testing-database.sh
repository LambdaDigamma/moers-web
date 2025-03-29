#!/usr/bin/env bash

psql -U postgres <<-EOSQL
    CREATE DATABASE testing;
    GRANT ALL PRIVILEGES ON DATABASE testing TO postgres;
EOSQL
