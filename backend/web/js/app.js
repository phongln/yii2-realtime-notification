/**
 * Created by phongln on 04/01/2017.
 */
$(document).ready(function () {
    // var data = ;
    var socket = io.connect('http://127.0.0.1:8890');
    socket.emit('initial', {onlyOnce: "1"});
    // socket.on('initial', function (data) {
    //     console.log(data);
        // $.ajax({
        //     url: form.attr('action'),
        //     type: 'post',
        //     data: form.serialize(),
        //     success: function (resp) {
        //         socket.emit('notification', resp);
        //         window.location.href = resp.reloadLink;
        // socket.emit('news', { hello: 'world' });
        // socket.on('my other event', function (data) {
        //     console.log(data);
        // });
        //     }
        // });
    // });
});