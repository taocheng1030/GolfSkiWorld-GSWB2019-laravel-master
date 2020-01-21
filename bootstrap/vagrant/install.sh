#!/usr/bin/env bash

# Variables
DIRECTORY=/var/www/gsw
SERVER_NAME=GSW
HOST_IP=192.168.10.10
HOST_NAME=gsw.loc
HOST_CONF_FILE=${HOST_NAME}.conf
HOST_CONF_PATH=${DIRECTORY}/bootstrap/vagrant/apache
DB_PASS=temp.123


# Update Package List & Update System Packages
apt-get update
apt-get -y upgrade


# Force Locale
echo "LC_ALL=en_US.UTF-8" >> /etc/default/locale
export LANGUAGE=en_US.UTF-8
export LANG=en_US.UTF-8
export LC_ALL=en_US.UTF-8
locale-gen en_US.UTF-8
dpkg-reconfigure locales


# Install Some Basic Packages
apt-get install -y mc software-properties-common python-software-properties curl libcurl3
apt-get install -y build-essential gcc git libmcrypt4 libpcre3-dev ntp unzip \
make python2.7-dev python-pip re2c supervisor unattended-upgrades libnotify-bin


# Install Some PPAs
apt-add-repository ppa:chris-lea/redis-server -y
add-apt-repository ppa:ondrej/php -y
add-apt-repository ppa:mc3man/trusty-media -y
curl --silent --location https://deb.nodesource.com/setup_6.x | bash -


# Update Package List
apt-get update


# Installing apache
apt-get install -y apache2
echo "ServerName ${SERVER_NAME}" >> /etc/apache2/apache2.conf

ln -s /vagrant ${DIRECTORY}

sudo cp ${HOST_CONF_PATH}/${HOST_CONF_FILE} /etc/apache2/sites-available/ -R
sudo a2ensite ${HOST_CONF_FILE}
sudo sed -i "2i${HOST_IP} ${HOST_NAME}" /etc/hosts

sudo a2enmod rewrite
service apache2 restart


## Installing php
apt-get -y install php5.6 php5.6-mcrypt php5.6-mbstring php5.6-curl php5.6-cli php5.6-mysql php5.6-pgsql php5.6-gd php5.6-intl php5.6-xsl php5.6-zip php5.6-xml php5.6-bcmath
apt-get install -y php5-imagick php5-apcu


## Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer


## Install MySQL, phpMyAdmin
debconf-set-selections <<< "mysql-server mysql-server/root_password password ${DB_PASS}"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password ${DB_PASS}"
debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true"
debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password ${DB_PASS}"
debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password ${DB_PASS}"
debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password ${DB_PASS}"
debconf-set-selections <<< "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2"
apt-get install -y mysql-server mysql-client phpmyadmin


## Set My Timezone
ln -sf /usr/share/zoneinfo/UTC /etc/localtime


## Add Vagrant User To WWW-Data
usermod -a -G www-data vagrant
id vagrant
groups vagrant


## Install Node
apt-get install -y nodejs
/usr/bin/npm install -g gulp
/usr/bin/npm install -g bower
/usr/bin/npm install -g yarn
/usr/bin/npm install -g grunt-cli


## Installing Redis
apt-get install -y redis-server


## Installing RabbitMQ
sudo apt-get install -y rabbitmq-server
sudo rabbitmq-plugins enable rabbitmq_management
sudo service rabbitmq-server restart


## Configure Supervisor
sudo update-rc.d supervisor defaults
service supervisor start


# FFMpeg
sudo apt-get install -y ffmpeg frei0r-plugins x264


## Clean Up
apt-get -y autoremove
apt-get -y clean
