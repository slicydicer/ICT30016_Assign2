<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Snort Alerts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            text-align: center;
            padding: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            font-size: 16px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f4f4f9;
        }
        tr:hover {
            background-color: #ddd;
        }
        .pagination {
            margin: 20px 0;
            text-align: center;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            border-radius: 5px;
        }
        .pagination a.active {
            background-color: #0056b3;
            font-weight: bold;
        }
        .pagination span {
            margin: 0 5px;
            padding: 8px 16px;
            font-size: 16px;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Search Snort Alerts</h1>
    <form method="GET" action="">
        <input type="text" name="keyword" placeholder="Enter keyword..." required value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
        <input type="submit" value="Search">
    </form>
    <?php
    if (isset($_GET['keyword'])) {
        $keyword = htmlspecialchars($_GET['keyword']);
        $file = '/var/log/snort/snort.alert.fast';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $resultsPerPage = 10;

        if (file_exists($file) && is_readable($file)) {
            $lines = file($file);
            $results = [];

            foreach ($lines as $line) {
                if (stripos($line, $keyword) !== false) {
                    $results[] = $line;
                }
            }

            $totalResults = count($results);
            $totalPages = ceil($totalResults / $resultsPerPage);
            $startIndex = ($page - 1) * $resultsPerPage;
            $currentPageResults = array_slice($results, $startIndex, $resultsPerPage);

            if ($totalResults > 0) {
                echo "<h2>Results for: <em>$keyword</em> ($totalResults found)</h2>";
                echo "<table>";
                echo "<tr><th>Timestamp</th><th>Alert</th></tr>";
                foreach ($currentPageResults as $result) {
                    // Extract timestamp and alert details
                    preg_match('/^(.*? )\[/', $result, $matches);
                    $timestamp = $matches[1] ?? 'N/A';
                    $alertDetails = htmlspecialchars(trim(str_replace($timestamp, '', $result)));
                    echo "<tr><td>$timestamp</td><td>$alertDetails</td></tr>";
                }
                echo "</table>";

                // Pagination with ellipsis
                echo "<div class='pagination'>";
                if ($totalPages <= 7) {
                    // Show all pages if total pages <= 7
                    for ($i = 1; $i <= $totalPages; $i++) {
                        $active = ($i == $page) ? "active" : "";
                        echo "<a class='$active' href='?keyword=$keyword&page=$i'>$i</a>";
                    }
                } else {
                    // Show first 2 pages
                    if ($page > 4) {
                        echo "<a href='?keyword=$keyword&page=1'>1</a>";
                        echo "<a href='?keyword=$keyword&page=2'>2</a>";
                        echo "<span>...</span>";
                    }

                    // Pages around current page
                    $start = max(3, $page - 1);
                    $end = min($totalPages - 2, $page + 1);
                    for ($i = $start; $i <= $end; $i++) {
                        $active = ($i == $page) ? "active" : "";
                        echo "<a class='$active' href='?keyword=$keyword&page=$i'>$i</a>";
                    }

                    // Show last 2 pages
                    if ($page < $totalPages - 3) {
                        echo "<span>...</span>";
                        echo "<a href='?keyword=$keyword&page=" . ($totalPages - 1) . "'>" . ($totalPages - 1) . "</a>";
                        echo "<a href='?keyword=$keyword&page=$totalPages'>$totalPages</a>";
                    }
                }
                echo "</div>";
            } else {
                echo "<p>No alerts found for keyword: <em>$keyword</em>.</p>";
            }
        } else {
            echo "<p>Unable to read the Snort alert file.</p>";
        }
    }
    ?>
    <a href="/">Back to Homepage</a>
</body>
</html>
