var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

const HOSTNAME = '127.0.0.1';
const PORT = 8890;

server.listen(PORT, HOSTNAME, function () {
    console.log("Server running at http://" + HOSTNAME + ":" + PORT);
});

io.on('connection', function(socket) {
    var redisClient = redis.createClient();
    redisClient.subscribe('notification');
    redisClient.on('message', function (channel, message) {
        console.log("New message: " + message + ". In channel: " + channel);
        socket.emit(channel, message);
    });

    socket.on('disconnect', function() {
        redisClient.quit();
    });
});
