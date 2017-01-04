/**
 * Created by phongln on 03/01/2017.
 */
$(document).ready(function () {
    var socket = io.connect('http://127.0.0.1:8890');
    function submitFormByAjax(form) {
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (resp) {
                socket.emit('notification', resp);
                window.location.href = resp.reloadLink;
            }
        });
    }

    $("#pushBtn").click(function () {
        submitFormByAjax($('#notificationForm'));
    });
    $("#changeBtn").click(function () {
        submitFormByAjax($('#defaultNotificationForm'));
    });
    $("#updateBtn").click(function () {
        submitFormByAjax($('#updateNotificationForm'));
    });
});
