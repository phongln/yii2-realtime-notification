/**
 * Created by phongln on 03/01/2017.
 */
$(document).ready(function () {
    var socket = io.connect('http://127.0.0.1:8890');
    $('#err-mess').html('');
    $("#pushBtn").click(function () {
        $('#err-mess').html('');
        var form = $('#notificationForm');
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (resp) {
                if(!resp.success) {
                    $('#err-mess').html(resp.message);
                    $('.alert').removeClass("hide");
                    $('.alert').addClass("show");
                } else {
                    socket.emit('notification', resp);
                    $('#changedList').append($('<li>').text("Schedule time at: " + resp.hour + ":" + resp.minute));
                    form[0].reset();
                }
            }
        });
    });
});
