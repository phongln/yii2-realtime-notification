function setValue(hour, minute) {
  $("#hour").val(hour);
  $("#minute").val(minute);
}

$(document).ready(function () {
  var socket = io.connect('http://127.0.0.1:8890/');
  socket.on('notification', function (data) {
    localStorage.hour = data.hour;
    localStorage.minute = data.minute;
    setValue(localStorage.hour, localStorage.minute);
  });
  setValue(localStorage.hour, localStorage.minute);
});
