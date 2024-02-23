#!/bin/bash

set -e

SSH_USER=$1
SERVER_IP=$2
BACKUP_FILENAME=$3
MYSQL_USER=$4
MYSQL_PASSWORD=$5

scp -C -o StrictHostKeyChecking=no -i $HOME/.ssh/id_rsa $HOME/.ssh/id_rsa $SSH_USER@$SERVER_IP:~/.ssh/id_rsa

scp -C -o StrictHostKeyChecking=no -i $HOME/.ssh/id_rsa ./restore.sh $SSH_USER@$SERVER_IP:./restore.sh
ssh -tt -o StrictHostKeyChecking=no -i $HOME/.ssh/id_rsa $SSH_USER@$SERVER_IP "chmod +x ./restore.sh && ./restore.sh $BACKUP_FILENAME $MYSQL_USER $MYSQL_PASSWORD"
