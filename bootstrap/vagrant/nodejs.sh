#!/usr/bin/env bash

# Variables
DIRECTORY=/var/www/gsw/node

cd ${DIRECTORY}


## Installing NodeJS modules
sudo npm -g install express
sudo npm -g install ioredis
sudo npm -g install socket.io


## Installing Forever (for node.js)
sudo npm -g install forever


## Starting notification server
forever start broadcast-server.js
