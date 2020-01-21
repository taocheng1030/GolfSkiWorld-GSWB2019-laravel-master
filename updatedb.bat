set DB_USER=root
set DB_PASS=root

artisan migrate:reset

mysql --user=%DB_USER% --password=%DB_PASS% alpha < database/countries-states-cities/cities.sql
mysql --user=%DB_USER% --password=%DB_PASS% alpha < database/countries-states-cities/countries.sql
mysql --user=%DB_USER% --password=%DB_PASS% alpha < database/countries-states-cities/states.sql

artisan migrate:refresh --seed
