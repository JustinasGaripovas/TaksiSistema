const subscribeToTopic = (topic, onReceive) =>{
    const es = new EventSource('http://localhost:3000/.well-known/mercure?topic=' + topic);
    es.onmessage = e => {
        // Will be called every time an update is published by the server
        // console.log(JSON.parse(e.data));
        onReceive(JSON.parse(e.data))
    }
}