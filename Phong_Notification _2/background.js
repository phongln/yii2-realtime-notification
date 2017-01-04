/*
  Displays a notification with the current time. Requires "notifications"
  permission in the manifest file (or calling
  "Notification.requestPermission" beforehand).
*/
function showPushed() {
  var currentTime = /(..)(:..)/.exec(new Date());     // The prettyprinted time.
  var scheduleTime = localStorage.time;
  var body = mess = "";
  if(localStorage.message != null) {
      body = scheduleTime + " " + localStorage.message;
  }

  if (JSON.parse(localStorage.firedNow)) {
    body = "Schedule time at: " + scheduleTime;
    if(localStorage.message != null) {
        body = scheduleTime + " " + localStorage.message;
    }
    mess = 'Change schedule time';
    var notification = new Notification(mess, {
        icon: '64.png',
        body: body
    });
    if(localStorage.message != null) {
        notification.onclick = function () {
            window.open(localStorage.url);
        };
    }
    localStorage.firedNow = false;
  }

  if(scheduleTime == currentTime[0]) {
    mess = 'Notification from schedule time';
    body = scheduleTime;
    if(localStorage.message != null) {
        body = scheduleTime + " " + localStorage.message;
    }
    var notification = new Notification(mess, {
        icon: '64.png',
        body: body
    });
    if(localStorage.message != null) {
        notification.onclick = function () {
            window.open(localStorage.url);
        };
    }
  }
}

function showDefault() {
    var currentTime = /(..)(:..)/.exec(new Date());     // The prettyprinted time.
    var body = mess = "";
    var defaultData = JSON.parse(localStorage.defaultData);

    if (JSON.parse(localStorage.firstRun)) {
        $.each(defaultData, function () {
            var notify_data = this;
            body = "Schedule time at: " + notify_data['time'];
            if(notify_data['message'] != null) {
                body = notify_data['time'] + " " + notify_data['message'];
            }
            mess = 'Default schedule time';
            var notification = new Notification(mess, {
                icon: '64.png',
                body: body
            });
            if(notify_data['url'] != '') {
                notification.onclick = function () {
                    window.open(notify_data['url']);
                };
            }
        });

        localStorage.firstRun = false;
    }

    if (JSON.parse(localStorage.firedNow)) {
        $.each(defaultData, function () {
            var notify_data = this;
            body = "Schedule time at: " + notify_data['time'];
            if(notify_data['message'] != null) {
                body = notify_data['time'] + " " + notify_data['message'];
            }
            mess = 'Change default schedule time';
            var notification = new Notification(mess, {
                icon: '64.png',
                body: body
            });
            if(notify_data['url'] != '') {
                notification.onclick = function () {
                    window.open(notify_data['url']);
                };
            }
        });

        localStorage.firedNow = false;
    }

    $.each(defaultData, function () {
        var notify_data = this;
        if(currentTime[0] == notify_data['time']) {
            mess = 'Notification from schedule time';
            body = notify_data['time'];
            if(notify_data['message'] != null) {
                body = notify_data['time'] + " " + notify_data['message'];
            }

            var notification = new Notification(mess, {
                icon: '64.png',
                body: body
            });
            if(notify_data['url'] != '') {
                notification.onclick = function () {
                    window.open(notify_data['url']);
                };
            }
        }
    });
}

function getInitialConfig() {
    $.ajax({
        url: 'http://yii2-realtime.dev/notification/initial',
        type: 'get',
        success: function (resp) {
            localStorage.defaultData = resp.defaultData;
        }
    });
}
// Conditionally initialize the options.
if (!localStorage.isInitialized) {
    localStorage.isInitialized = true; // The option initialization.
    getInitialConfig();
}
localStorage.firedNow = false;
localStorage.firstRun = true;
// Test for notification support.
if (window.Notification) {
    var socket = io.connect('http://127.0.0.1:8890/');
    socket.on('notification', function (data) {
    if(data.type == 'pushed') {
        localStorage.time = data.time;
        localStorage.message = data.message;
        localStorage.url = data.url;
        localStorage.firedNow = true;

        showPushed();
    } else {
        localStorage.defaultData = data.defaultData;
        localStorage.firedNow = true;

        showDefault();
    }
  });
  // While activated, show notifications at the display frequency.
  if (JSON.parse(localStorage.isInitialized)) { showPushed(); showDefault(); }

  setInterval(function() {
    if (JSON.parse(localStorage.isInitialized)) { showPushed(); showDefault();}
  }, 60000);
}