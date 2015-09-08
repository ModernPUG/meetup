var $BrainSocket = new BrainSocket(
	new WebSocket('ws://localhost:8080'),
	new BrainSocketPubSub()
);

$BrainSocket.event.listen('app.success',function(data){
	console.log('An app success message was sent');
	console.log(data);
});

$BrainSocket.event.listen('app.error',function(data){
	console.log('An app error message was sent');
	console.log(data);
});