
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WebSockets Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.min.js"></script>
</head>
<body>
    <div id="app">
        <websockets-dashboard
            :port="{{ json_encode($port ?? 6001) }}"
            :apps="{{ json_encode($apps) }}"
            csrf-token="{{ csrf_token() }}"
            auth-endpoint="{{ url(request()->path() . '/auth') }}"
            api-endpoint="{{ url(request()->path() . '/api') }}"
            send-endpoint="{{ url(request()->path() . '/event') }}"
            statistics-endpoint="{{ url(request()->path() . '/statistics') }}"
        />
    </div>

    {{-- If your custom JS component is not loaded, fallback --}}
    <script>
        console.log("Dashboard Loaded");
    </script>
</body>
</html>

