// setup mysql connection
var mysql = require('mysql');
var dbconfig = require('./../../config/database');
var connection = mysql.createConnection(dbconfig.connection);
connection.query('USE ' + dbconfig.database);

module.exports = function (io) {
	io.sockets.on('connection', function (socket) {
		console.log("connection successfull to socket..");

		var userId = ''; //current user's id
		var POLLING_INTERVAL = 30000;


		//to get the current user's id from client side
		socket.on('currentuser', function(data){
			userId = data;
			console.log("currentuser's id : "+userId);
		});			

		socket.on('disconnect', function(){
			console.log("disconnected...");
		});

		//@desc - save chat to db
		socket.on('sendchat', function(message, arrToUsers, chatId){
			console.log("server side, sendchat handler, chat id : "+chatId+" , message recieved : "+message+" , recieved ids : ");
			//check for length of arrToUsers
			
			//arrToUsers.forEach(function(val){
					// console.log(val);
					// @save chat to db here i.e. insert query here
					// var chatMessage  = {from_user: fromUser, to_user: user, message: message};
					// var query = connection.query('INSERT INTO chat SET ?', chatMessage, function(err, result) {});
					if (chatId) {
						//insert into
						//1.message
						//2.messageReceiver
						var messageData = {chatId: chatId, message: message,userId: userId};
						var messageInsertQuery = connection.query('INSERT INTO message SET ?', messageData, function(err, result) {
							if (err) console.log("error :insertdata: messageTable");

							var messageId = '';
							messageId = result.insertId;

							arrToUsers.forEach(function(val){
								//for each receiver of message
								var messageReceiverData = {messageId: messageId,userId: val};
								var messageReceiverInsertQuery = connection.query('INSERT INTO messageReceiver SET ?', messageReceiverData, function(err, result) {
									if (err) console.log("error :insertdata: messageTable");

									//return a json object i.e emit a new event
								});											
							});
						});
					} else {
						//insert into
						//1.chat
						//2.chatUser
						//3.message
						//4.messageReceiver
						//5.return a json object of chat id and users
						var chatId = '';
						var messageId = '';
						// var newChatToBeCachedClient = {
						// 	id : '',
						// 	users : [
						// 	],
						// };							

						var chat  = {createdDate: 'now()'};
						var chatInsertquery = connection.query('INSERT INTO chat SET ?', chat, function(err, result) {
							if (err) console.log("error :insertdata: chatTable");

							
							chatId = result.insertId;
							console.log("inserted to chat table ,chatId : "+chatId);console.log(result);
							// newChatToBeCachedClient.id = result.insertId;

							var chatUserData = {chatId : chatId,userId: userId};
							var chatUserInsertquery = connection.query('INSERT INTO chatUser SET ?', chatUserData, function(err, result) {
								if (err) console.log("error :insertdata: chatUserTable");

								var messageData = {chatId: chatId, message: message,userId: userId};
								var messageInsertQuery = connection.query('INSERT INTO message SET ?', messageData, function(err, result) {
									if (err) console.log("error :insertdata: messageTable");

									messageId = result.insertId;

									arrToUsers.forEach(function(val){
										//for each receiver of message
										var messageReceiverData = {messageId: messageId,userId: val};
										var messageReceiverInsertQuery = connection.query('INSERT INTO messageReceiver SET ?', messageReceiverData, function(err, result) {
											if (err) console.log("error :insertdata: messageTable");

											
										});											
									});


									//here create a new json
									//return a json object i.e emit a new event
									var newChatToBeCachedClient = {
										id : chatId,
										users : [
										],
									};
									//ListData.settings.subnav.push({label : "added_later", url:'#added_later'});
									arrToUsers.forEach(function(val){
										newChatToBeCachedClient.users.push({user_id:val});
									});

									newChatToBeCachedClient.users.push({user_id:userId});

									console.log(newChatToBeCachedClient);
									console.log("emitting result chat id is :"+chatId);
									socket.emit('updateContactsCache', newChatToBeCachedClient);
								});								
							});								
						});


					}
			//});
		});

		// var pollingLoop = function () {
		// 	console.log("repeat itself after POLLING_INTERVAL");
           	
		// };

		//run this anonymous function after POLLING_INTERVAL seconds
		//we will send the chats at client side
		setInterval(function() { 
			//console.log("repeat after "+POLLING_INTERVAL+" milli seconds") 
			var messagesSend = [];
			var messagesReceived = [];
			
			var query = connection.query('select message.chatId,message.messageId,message.message,message.userId as senderId,messageReceiver.userId as receiverId from message join messageReceiver on message.messageId = messageReceiver.messageId where message.userId='+userId+';');
			query
			.on('error', function(err) {
				console.log(err);
			})
			.on('result', function(res) {
				// console.log(res);
				messagesSend.push(res);
				socket.emit('updateChatsSentMessages', messagesSend);
			
			})
			.on('end', function() {
				console.log("query ends..")
			});
			
			var query = connection.query('select message.chatId,messageReceiver.messageId,messageReceiver.userId as receiverId,message.userId as senderId,message.message from messageReceiver join message on messageReceiver.messageId = message.messageId where messageReceiver.userId ='+userId+';');
			query
			.on('error', function(err) {
				console.log(err);
			})
			.on('result', function(result) {
				// console.log(res);
				messagesReceived.push(result);
				socket.emit('updateChatsReceivedMessages', messagesReceived);
			
			})
			.on('end', function() {
				
			});

		},POLLING_INTERVAL);
	});
};