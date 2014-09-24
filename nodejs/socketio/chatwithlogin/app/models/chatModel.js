module.exports = function (io) {
	io.sockets.on('connection', function (socket) {
		console.log("connection successfull to socket..");
		socket.on('disconnect', function(){
			console.log("disconnected...")
		});
	});
};