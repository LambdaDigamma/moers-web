#!/bin/bash

set -e

SSH_KEY=$1

# Add Docker's official GPG key:
sudo apt-get update
sudo apt-get install ca-certificates curl gnupg
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo chmod a+r /etc/apt/keyrings/docker.gpg

# Add the repository to Apt sources:
echo \
  "deb [arch="$(dpkg --print-architecture)" signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  "$(. /etc/os-release && echo "$VERSION_CODENAME")" stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
sudo apt-get update

sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

# Create the user to not run as root

useradd -G www-data,root,sudo,docker -u 1000 -d /home/tfdoors tfdoors
mkdir -p /home/tfdoors/.ssh
touch /home/tfdoors/.ssh/authorized_keys
chown -R tfdoors:tfdoors /home/tfdoors
chown -R tfdoors:tfdoors /usr/src
chmod 700 /home/tfdoors/.ssh
chmod 644 /home/tfdoors/.ssh/authorized_keys

if [ -n "$SSH_KEY" ]; then
  echo "$SSH_KEY" >> /home/tfdoors/.ssh/authorized_keys
fi

echo "tfdoors ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers.d/tfdoors
