var mongoose = require('mongoose');
var Schema = mongoose.Schema;
var ChatSchema = new Schema({
    message: String,
  	toUser: String,
  	fromUser: String
});
module.exports = mongoose.model('chats', ChatSchema);