var fs = require('fs');
var settings = JSON.parse(fs.readFileSync('broadcast-config.json', 'utf8'));

var https = require('https');

var express = require('express');
var app = express();

var options = {
    key: fs.readFileSync('/etc/letsencrypt/live/admin.golfskiworld.com/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/admin.golfskiworld.com/fullchain.pem'),
}

var server = https.createServer(options, app);
var io = require('socket.io').listen(server);

var Redis = require('ioredis');
var redis = new Redis(settings.redis);

//

/*
 * Listen to local Redis broadcasts
 */

redis.psubscribe('*', function(err, count) {});

redis.on('pmessage', function(pattern, channel, payload) {
    payload = JSON.parse(payload);

    // Merge channel into payload
    payload.channel = channel;

    // Send the data through to any client in the channel room (!)
    // io.sockets.in(channel).emit(payload.event, payload.data);

    io.emit(channel, payload);
});

/*
 * Server
 */

// Start listening for incoming client connections
io.on('connection', function(socket) {
    // console.log('NEW CLIENT CONNECTED');
    socket.on('disconnect', function() {
        // console.log('DISCONNECT')
    });
});

// Start listening for client connections
server.listen(settings.server.port, function() {
    console.log('Listening to incoming client connections on port ' + settings.server.port)
});