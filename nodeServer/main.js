var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);

// const HOSTNAME = '127.0.0.1'; // Development config
const HOSTNAME = '125.212.210.113'; // Production config
const PORT = 8890;

server.listen(PORT, HOSTNAME, function () {
    console.log("Server running at http://" + HOSTNAME + ":" + PORT);
});

io.on('connection', function(socket) {
    socket.on('notification', function(data){
        console.log(data);
        io.emit('notification', data);
    });
});
