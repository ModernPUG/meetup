function BrainSocket(WebSocketConnection,BrainSocketPubSub){
	this.connection = WebSocketConnection;
	this.Event = BrainSocketPubSub;

	this.connection.BrainSocket = this;

	this.connection.digestMessage = function(data){
		try{
			var object = JSON.parse(data);

			if(object.server && object.server.event){
				this.BrainSocket.Event.fire(object.server.event,object);
			}else{
				this.BrainSocket.Event.fire(object.client.event,object);
			}

		}catch(e){
			this.BrainSocket.Event.fire(data);
		}
	}

	this.connection.onerror = function(e){
		console.log(e);
	}

	this.connection.onmessage = function(e) {
		this.digestMessage(e.data);
	}

	this.success = function(data){
		this.message('app.success',data);
	}

	this.error = function(data){
		this.message('app.error',data);
	}

	this.message = function(event,data){
		var json = {client:{}};
		json.client.event = event;

		if(!data){
			data = [];
		}

		json.client.data = data;

		this.connection.send(JSON.stringify(json));
	}


}