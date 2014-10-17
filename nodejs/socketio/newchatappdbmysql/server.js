var app = require('express').createServer();
var io = require('socket.io').listen(app);
io.set('log level', 1);
var mysql = require('mysql'),
  connectionsArray = [],
  connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'tech',
    database: 'node',
    port: 3306
  });

//listen to port number
app.listen(5555);

// routing
app.get('/', function (req, res) {
  res.sendfile( '/client.html' , {root:__dirname});
});

connection.connect(function(err) {
  if(err) console.log(err);
});


// usernames which are currently connected to the chat
var usernames = {};

//will contain the complete socket with key as username
var users ={};


io.sockets.on('connection', function (socket) {
	console.log("SERVER started");

	// when the client emits 'sendchat', this listens and executes
	socket.on('sendchat', function (data) {
		// we tell the client to execute 'updatechat' with 2 parameters
		io.sockets.emit('updatechat', socket.username, data);
	});

	// when the client emits 'adduser', this listens and executes
	socket.on('adduser', function(username){
		// we store the username in the socket session for this client
		socket.username = username;
		// add the client's username to the global list
		usernames[username] = username;
		// string the user and their sockets
		users[username] = socket;
		// echo to new client that he/she is now connected
		socket.emit('updatechat', 'SERVER', 'you have connected');
		// echo globally (all clients) that a person has connected ,except that person
		socket.broadcast.emit('updatechat', 'SERVER', username + ' has connected');
		// update the list of users in chat, client-side
		io.sockets.emit('updateusers', usernames);
	});

	socket.on('sendMessage', function(message, arrToUsers, fromUser){
		arrToUsers.forEach(function(val){
			for(var user in users){
			    if (val == user || val == fromUser) {
			    	users[user].emit('updatechat', fromUser, message);
					var chatMessage  = {from_user: fromUser, to_user: user, message: message};
					var query = connection.query('INSERT INTO chat SET ?', chatMessage, function(err, result) {});
			    }
			}
		});
	});

	// when the user disconnects.. perform this
	socket.on('disconnect', function(){
		// remove the username from global usernames list
		delete usernames[socket.username];
		// update list of users in chat, client-side
		io.sockets.emit('updateusers', usernames);
		// echo globally that this client has left
		socket.broadcast.emit('updatechat', 'SERVER', socket.username + ' has disconnected');
	});
});