//var tid = document.getElementById("field_tid").value;
var url = "http://localhost:8000/getUserProfile.php?q=1";
downloadUrl(url, function(data) {
var xml = data.responseXML;
var track = xml.documentElement.getElementsByTagName('user');
console.log(data);
console.log(xml);
title = track[0].getAttribute('UserName');
length = track[0].getAttribute('Realname');
genre = track[0].getAttribute('Email');
console.log(title);
var display = document.createElement('div');
display.appendChild(document.createTextNode(title + ', ' + length + ', ' + genre));
document.body.appendChild(display);
console.log(display);


function downloadUrl(url, callback) {
    var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

    request.open('GET', url, true);
    request.send(null);
    return 0;
}

function doNothing() {}
