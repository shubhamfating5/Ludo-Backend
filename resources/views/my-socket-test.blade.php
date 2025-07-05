<!DOCTYPE html>
<html>
<head>
    <title>WebSocket Test</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
</head>
<body>
<h1>WebSocket Client</h1>
<script>
    const pusher = new Pusher('local', {
        wsHost: window.location.hostname,
        wsPort: 6001,
        forceTLS: false,
        disableStats: true,
        enabledTransports: ['ws']
    });

    const channel = pusher.subscribe('game.120'); // Example
    channel.bind('GameTicked', function (data) {
        console.log('Received:', data);
    });
</script>
</body>
</html>
