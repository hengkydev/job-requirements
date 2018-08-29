
var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var request = require('axios');
const FormData = require('form-data');
var EventEmitter = require('events');

const emitter = new EventEmitter();
const form = new FormData();

/*emitter.setMaxListeners(99);
var url = 'http://www.hawk1hunter.aksa/api/';

request.defaults.baseURL = 'http://www.hawk1hunter.aksa/api/';
request.defaults.headers.common['Apikey'] = 'key-20180325105323-qhahdxuwag45vdu7d5fkrdnwsetm58vb';*/
//request.defaults.headers.common['Content-Type'] = 'multipart/form-data';

app.get('/', function(req, res){
	res.sendFile(__dirname + '/public/index.html');
});


io.on('connection', function(socket){
  //var user_socket 		= [];
  console.log('a user connected',socket.id);

  socket.on('disconnect', function(){
    console.log('user disconnected',socket.id);
  });

 /* socket.on("global_index_start",	function(user){
	console.log(user);
	user_socket[socket.id+'__global_index'] = setInterval(function(){
		form.append('user_id', user);
		request.post("globalindex",form,{
			headers:  form.getHeaders()
		})
		.then(function (response) {
			io.emit('global_index_'+user,response.data);
		})
		.catch(function (error) {
			console.log(error);
		});
	}, 3000);
   })*/

  socket.on('tradingidea', function(msg){
    console.log('message: ' + msg);
    io.emit('tradingidea', msg);
  });
  
});


http.listen(3000, function(){
  console.log('listening on *:3000');
});