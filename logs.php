<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Logs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }
        pre {
            background: #333;
            color: #f4f4f9;
            padding: 10px;
            overflow-x: auto;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Apache Access Logs</h1>
    <pre><?php echo htmlspecialchars(shell_exec('sudo tail -n 50 /var/log/apache2/access.log')); ?></pre>
    <br>
    <a href="/">Back to Homepage</a>
</body>
</html>
