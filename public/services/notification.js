const subscribeToTopic = (topic, onReceive) => {
    const es = new EventSource('http://localhost:3000/.well-known/mercure?topic=' + topic);
    es.onmessage = e => {
        // Will be called every time an update is published by the server
        // console.log(JSON.parse(e.data));
        onReceive(JSON.parse(e.data))
    }
}

const showNotification = (text, type = 'info') => {
    const notification = document.createElement("span")
    notification.innerText = text;
    document.getElementById("notifications-container").appendChild(notification);
    notification.classList.add("notification", "open", "type");
    setTimeout(() => {
        notification.classList.remove("open");
        // setTimeout(() => document.getElementById("notifications-container").removeChild(notification),4000)
    }, 4000)
}