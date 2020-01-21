var settings = {
    socket : {
        server: {
            host: window.location.host.split(':')[0],
            port: 8080
        },
        options : {
            secure: false,
            rejectUnauthorized: false
        }
    },
    notification : {
        info : $('.notification-info', '.navbar-custom-menu'),
        upload : $('.notification-files', '.navbar-custom-menu'),
    }
};

var _notifications = new Notifications();

var socket = io.connect('//' + settings.socket.server.host + ':' + settings.socket.server.port, settings.socket.options);

socket.on('connect', function () {
    console.log('CONNECTED');
});

socket.on('notification', function (payload)
{
    switch (payload.event) {
        case 'booking' :
            _notifications.add(settings.notification.info, payload.data);
            break;

        case 'uploaded' :
            _notifications.add(settings.notification.upload, payload.data);
            break;
    }

    console.log(payload);
});

socket.on('disconnect', function () {
    console.log('DISCONNECT')
});
