#!/bin/bash

# ------------------------------------------------------------------------------
# Takes the previously running container down, updates and starts the new one.
# Usage: ./deploy.sh
# ------------------------------------------------------------------------------

set -e

cd /home/tfdoors/production

sudo docker compose -f docker-compose.prod.yml down
sudo docker compose -f docker-compose.prod.yml up -d --remove-orphans
