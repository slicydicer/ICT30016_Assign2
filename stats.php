<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Stats</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f9;
            color: #333;
        }
        h1 {
            color: #007BFF;
        }
        table {
            margin: auto;
            border-collapse: collapse;
            width: 50%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Server Statistics</h1>
    <table>
        <tr>
            <th>Metric</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Uptime</td>
            <td><?php echo shell_exec('uptime -p'); ?></td>
        </tr>
        <tr>
            <td>Memory Usage</td>
            <td><?php echo shell_exec('free -h | grep Mem | awk \'{print $3 " / " $2}\';'); ?></td>
        </tr>
        <tr>
            <td>Disk Usage</td>
            <td><?php echo shell_exec('df -h / | grep / | awk \'{print $3 " / " $2 " (" $5 ")"}\';'); ?></td>
        </tr>
    </table>
    <br>
    <a href="/">Back to Homepage</a>
</body>
</html>
