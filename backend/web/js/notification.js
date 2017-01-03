/**
 * Created by phongln on 03/01/2017.
 */
$(document).ready(function () {
    var socket = io.connect('http://127.0.0.1:8890');
    socket.on('notification', function (data) {
        data = $.parseJSON(data);
        var mess = "hour: " + data.hour + " | minute: " + data.minute;
        $('#changedList').append($('<li>').text(mess));
    });
    $("#pushBtn").click(function () {
        var form = $('#notificationForm');
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (resp) {
                form[0].reset();
            }
        });
    });
});
