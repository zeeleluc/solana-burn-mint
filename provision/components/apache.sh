#!/bin/bash

apt-get update
apt-get install -y apache2

cp /var/www/provision/config/apache/vhosts/solana-burn-mint.local.conf /etc/apache2/sites-available/solana-burn-mint.local.conf

a2dissite 000-default
a2ensite solana-burn-mint.local.conf
a2enmod rewrite
service apache2 restart

# ssl certificate for domain
sudo apt install openssl
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/ssl/private/solana-burn-mint.local.key \
    -out /etc/ssl/certs/solana-burn-mint.local.crt \
    -subj "/C=US/ST=CA/L=San Francisco/O=Example, Inc./OU=IT Department/CN=solana-burn-mint.local"
sudo a2enmod ssl
sudo systemctl restart apache2
