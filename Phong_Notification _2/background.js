/*
  Displays a notification with the current time. Requires "notifications"
  permission in the manifest file (or calling
  "Notification.requestPermission" beforehand).
*/
function show() {
  var time = /(..)(:..)/.exec(new Date());     // The prettyprinted time.
  var _hour = localStorage.hour + ":" + localStorage.minute;
  var body = "Default schedule time is: " + _hour;
  var mess = "Start notification";

  if (JSON.parse(localStorage.firstRun)) {
    new Notification(mess, {
      icon: '64.png',
      body: body
    });
    localStorage.firstRun = false;
  }
  if (JSON.parse(localStorage.firedNow)) {
    body = "Schedule time at: " + _hour;
    mess = 'Change schedule time';
    new Notification(mess, {
      icon: '64.png',
      body: body
    });
    localStorage.firedNow = false;
  }
  if(_hour == time[0]) {
    mess = 'Notification from schedule time';
    new Notification(mess, {
      icon: '64.png',
      body: _hour
    });
  }

  if(time[0] == "08:30") {
    mess = 'Time to start working';
    new Notification(mess, {
      icon: '64.png',
      body: time[0]
    });
  } else if(time[0] == "12:00") {
    mess = 'Time for lunch';
    new Notification(mess, {
      icon: '64.png',
      body: time[0]
    });
  } else if(time[0] == "13:30") {
    mess = 'Time for get back to work';
    new Notification(mess, {
      icon: '64.png',
      body: time[0]
    });
  } else if(time[0] == "18:00") {
    mess = 'Time to go home';
    new Notification(mess, {
      icon: '64.png',
      body: time[0]
    });
  }
}
// Conditionally initialize the options.
if (!localStorage.isInitialized) {
  localStorage.isInitialized = true; // The option initialization.
  localStorage.hour = "8";
  localStorage.minute = "00";
}
localStorage.firedNow = false;
localStorage.firstRun = true;
// Test for notification support.
if (window.Notification) {
  var socket = io.connect('http://127.0.0.1:8890/');
  socket.on('notification', function (data) {
    data = $.parseJSON(data);
    localStorage.hour = data.hour;
    localStorage.minute = data.minute;
    localStorage.firedNow = true;
    show();
  });
  // While activated, show notifications at the display frequency.
  if (JSON.parse(localStorage.isInitialized)) { show(); }

  setInterval(function() {
    if (JSON.parse(localStorage.isInitialized)) { show(); }
  }, 60000);
}
