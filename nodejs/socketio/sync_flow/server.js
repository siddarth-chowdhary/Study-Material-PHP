var http = require('http');
var async = require("async");

http.createServer(function (req, res) {
  res.writeHead(200, {'Content-Type': 'text/html; charset=utf-8'});
  
  function callSync() {
  async.series([
    function(callback) { 
	res.write("1st line<br />"); 
	callback(null, "First"); //if we pass some value in the callback call the below functions will not run
    },
    function(callback) { 
	res.write("2nd line<br />"); 
	callback(null, "Second"); 
    },
    function(callback) { 
	res.write("3rd line<br />"); 
	callback(null, "Third");
    },
    function(callback) {
	res.write("4th line<br />"); 
	callback(null, "Fourth"); 
    },
    function(callback) { 
	res.write("5th line<br />"); 
	callback(null, "Fifth");  
    }],
    function(err, results) { 
	//receives an array of results when functions have completed i.e. the second arguement
	console.log("this is the callback...");	
	console.log("first arg: "+err+" second arguement"+results);
	res.end() 
    }
  );
  }


callSync();

}).listen(8778);

