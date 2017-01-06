/******************/
//*DEFAULT CONFIG*//
/******************/
var secret = 'dc9b9efd3e02d2e6e2800fb2b61421f7';
// Production config
var domain = 'http://chromeext.somo.vn/';
var io_connect = 'http://125.212.210.113:8890';

// Development config
// var domain = 'http://chrome-ext-notification.dev/';
// var io_connect = 'http://127.0.0.1:8890';

/**************************************/
//*Function showPushed or showDefault*//
/**************************************/
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
      body = localStorage.message;
  }

  if(scheduleTime == currentTime[0]) {
    mess = localStorage.title;
    body = scheduleTime;
    if(localStorage.url != null) {
        body = localStorage.message;
    }
    var notification = new Notification(mess, {
        icon: '64.png',
        body: body
    });
    if(localStorage.url != '') {
        notification.onclick = function () {
            window.open(localStorage.url);
        };
    }
  }
}

function showDefault() {
    var currentTime = /(..)(:..)/.exec(new Date());     // The prettyprinted time.
    var body = mess = "";
    var defaultData = [];
    $.ajax({
        url: domain + 'notification/get-default-notifications',
        type: 'get',
        data: {secret: secret},
        success: function (resp) {
            defaultData = JSON.parse(resp.defaultData);
            if (JSON.parse(localStorage.firstRun)) {
                $.each(defaultData, function () {
                    var notify_data = this;
                    body = "Schedule time at: " + notify_data['time'];
                    if(notify_data['message'] != null) {
                        body = notify_data['message'];
                    }
                    mess = notify_data['title'];
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

            $.each(defaultData, function () {
                var notify_data = this;
                if(currentTime[0] == notify_data['time']) {
                    mess = notify_data['title'];
                    body = notify_data['time'];
                    if(notify_data['message'] != null) {
                        body = notify_data['message'];
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
    });
}

/************************/
//*INITIALIZE EXTENSION*//
/************************/
// Conditionally initialize the options.
if (!localStorage.isInitialized) {
    localStorage.isInitialized = true; // The option initialization.
}
// Test for notification support.
if (window.Notification) {
    localStorage.firstRun = true;
    var socket = io.connect(io_connect);
    socket.on('notification', function (data) {
        if(data.type == 'pushed') {
            localStorage.time = data.time;
            localStorage.title = data.title;
            localStorage.message = data.message;
            localStorage.url = data.url;

            showPushed();
        } else {
            showDefault();
        }
    });
  // While activated, show notifications at the display frequency.
  if (JSON.parse(localStorage.isInitialized)) { showPushed(); showDefault(); }

  setInterval(function() {
    if (JSON.parse(localStorage.isInitialized)) { showPushed(); showDefault();}
  }, 60000);
}