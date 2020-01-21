#!/usr/bin/env bash

# Variables
DB_NAME=alpha
DB_ROOT_USER=root
DB_ROOT_PASS=a12345678!
DB_DEV_USER=alpha
DB_DEV_PASS=ALTHQNEJt9rx53uN


# Grant access and create database
mysql --user="${DB_ROOT_USER}" --password="${DB_ROOT_PASS}" -e "GRANT ALL ON *.* TO '${DB_ROOT_USER}'@'0.0.0.0' IDENTIFIED BY '${DB_ROOT_PASS}' WITH GRANT OPTION;"
mysql --user="${DB_ROOT_USER}" --password="${DB_ROOT_PASS}" -e "CREATE USER '${DB_DEV_USER}'@'0.0.0.0' IDENTIFIED BY '${DB_DEV_PASS}';"
mysql --user="${DB_ROOT_USER}" --password="${DB_ROOT_PASS}" -e "GRANT ALL ON *.* TO '${DB_DEV_USER}'@'0.0.0.0' IDENTIFIED BY '${DB_DEV_PASS}' WITH GRANT OPTION;"
mysql --user="${DB_ROOT_USER}" --password="${DB_ROOT_PASS}" -e "GRANT ALL ON *.* TO '${DB_DEV_USER}'@'%' IDENTIFIED BY '${DB_DEV_PASS}' WITH GRANT OPTION;"
mysql --user="${DB_ROOT_USER}" --password="${DB_ROOT_PASS}" -e "FLUSH PRIVILEGES;"
mysql --user="${DB_ROOT_USER}" --password="${DB_ROOT_PASS}" -e "CREATE DATABASE ${DB_NAME} character set utf8 collate utf8_unicode_ci;"
service mysql restart


# Import tables
mysql --user="${DB_ROOT_USER}" --password="${DB_ROOT_PASS}" alpha < database/countries-states-cities/cities.sql
mysql --user="${DB_ROOT_USER}" --password="${DB_ROOT_PASS}" alpha < database/countries-states-cities/countries.sql
mysql --user="${DB_ROOT_USER}" --password="${DB_ROOT_PASS}" alpha < database/countries-states-cities/states.sql


# Make migration
./artisan migrate --seed


# Clear all cache
./artisan cache:clear
./artisan config:clear
./artisan route:clear
./artisan view:clear


# Composer
composer dumpautoload
