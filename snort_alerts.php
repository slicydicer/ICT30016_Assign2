<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Snort Alerts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            text-align: center;
            padding: 20px;
        }
        pre {
            background-color: #000;
            color: #0f0;
            padding: 10px;
            border-radius: 5px;
            text-align: left;
            overflow-y: scroll;
            max-height: 400px;
        }
    </style>
</head>
<body>
    <h1>Live Snort Alerts</h1>
    <pre id="alerts">Loading alerts...</pre>
    <script>
        function fetchAlerts() {
            fetch('snort_alerts_fetch.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('alerts').innerHTML = data;
                })
                .catch(error => {
                    document.getElementById('alerts').innerHTML = 'Error loading alerts.';
                });
        }
        setInterval(fetchAlerts, 2000); // Refresh every 2 seconds
        fetchAlerts();
    </script>
    <a href="/">Back to Homepage</a>
    </body>
</body>
</html>

