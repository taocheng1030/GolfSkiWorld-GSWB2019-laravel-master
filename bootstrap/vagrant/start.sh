#!/usr/bin/env bash

# Variables
DIRECTORY=/var/www/gsw
CONF_PATH=${DIRECTORY}/bootstrap/vagrant


# Supervisor
for vhFile in ${CONF_PATH}/supervisor/*.conf
do
    sudo cp ${CONF_PATH}/supervisor/*.conf /etc/supervisor/conf.d/ -R
done

echo "" >> /etc/supervisor/supervisord.conf
echo "[inet_http_server]" >> /etc/supervisor/supervisord.conf
echo "port = 0.0.0.0:9001" >> /etc/supervisor/supervisord.conf
echo "username = zaraffa" >> /etc/supervisor/supervisord.conf
echo "password = zaraffa" >> /etc/supervisor/supervisord.conf

sudo supervisorctl reload