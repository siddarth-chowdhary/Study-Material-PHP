var http = require('http');

var user = {
  username: 'Siddarth Chowdhary',
  email: 'schowdhary@clavax.us',
};

var userString = JSON.stringify(user);

var headers = {
  'Content-Type': 'application/json',
  'Content-Length': userString.length
};

var options = {
  host: 'verses.local',
  path: '/index.php/admin/login/test/',
  port: 80,
  method: 'POST',
  headers: headers
};

var req = http.request(options, function(res) {
  res.setEncoding('utf-8');

  var responseString = '';

  res.on('data', function(data) {
    responseString += data;
  });

  res.on('end', function() {
    var resultObject = JSON.parse(responseString);
    console.log(":::: response received ::::");
    console.log(resultObject);
  });
});

req.on('error', function(e) {
  // TODO: handle error.
});

req.write(userString);
req.end();
