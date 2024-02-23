#!/bin/bash

# ------------------------------------------------------------------------------
# Removes a docker image from GitHub Container Registry
# Usage: remove-image.sh <image> <tag> <dockerhub-username> <dockerhub-password>
# ------------------------------------------------------------------------------

set -e

IMAGE=$1
TAG=$2
DOCKERHUB_USERNAME=$3
DOCKERHUB_PASSWORD=$4

curl -s -X POST \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d "{\"username\":\"$DOCKERHUB_USERNAME\", \"password\":\"$DOCKERHUB_PASSWORD\"}" \
  https://ghcr.io/v2/users/login \
  -o response.json

token=$(jq -r '.token' response.json)

curl -i -X DELETE \
  -H "Accept: application/json" \
  -H "Authorization: JWT $token" \
  https://ghcr.io/v2/repositories/inventas/$IMAGE/tags/$TAG
