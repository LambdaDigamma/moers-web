#!/bin/bash

set -e

BACKUP_FILENAME=$1
MYSQL_USER=$2
MYSQL_PASSWORD=$3

OLD_PROJECT_DIR="/www/htdocs/w016de0b/24doors.app/www/src"

PROJECT_DIR="/usr/src"
BACKUP_DIR=$PROJECT_DIR"/storage/app/backup"
BACKUP_ZIP=$PROJECT_DIR"/storage/app/backup.zip"

cd "/home/tfdoors/staging"

#docker compose exec app aws s3 cp s3://24doors-production-backups/"$BACKUP_FILENAME" $BACKUP_ZIP --endpoint-url https://6a8c607408230af28bc4b71715146f7b.eu.r2.cloudflarestorage.com
#docker compose exec app unzip -o $PROJECT_DIR"/storage/app/backup.zip" -d $BACKUP_DIR

docker compose exec app php $PROJECT_DIR"/artisan" down

# Restore database
#docker compose exec app mysql -u$MYSQL_USER -p$MYSQL_PASSWORD 24doors < $BACKUP_DIR"/db-dumps/mysql-24doors.sql"
#docker compose exec app mysql -u $MYSQL_USER -p $MYSQL_PASSWORD 24doors < "$BACKUP_DIR/db-dumps/mysql-d0340805.sql"

docker compose exec app sh -c "mysql -hmysql -u$MYSQL_USER -p'$MYSQL_PASSWORD' 24doors < $BACKUP_DIR/db-dumps/mysql-d0340805.sql"

# Copy the current files
# docker compose exec app mv $PROJECT_DIR"/.env" $PROJECT_DIR"/.env_before_restore"
docker compose exec app mv $PROJECT_DIR"/storage/app/public" $PROJECT_DIR"/storage/app/public_before_restore"

# Restore old files from backup
#docker compose exec app mv $BACKUP_DIR"/"$PROJECT_DIR"/.env" $PROJECT_DIR"/.env"
docker compose exec app mv $BACKUP_DIR"/"$OLD_PROJECT_DIR"/storage/app/public" $PROJECT_DIR"/storage/app/public"

docker compose exec app php $PROJECT_DIR"/artisan" storage:link
docker compose exec app php $PROJECT_DIR"/artisan" optimize:clear

docker compose exec app php $PROJECT_DIR"/artisan" up
