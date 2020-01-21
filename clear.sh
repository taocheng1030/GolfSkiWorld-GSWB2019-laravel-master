#!/bin/bash 

./artisan cache:clear
./artisan config:clear
./artisan route:clear
./artisan view:clear
composer dumpautoload
