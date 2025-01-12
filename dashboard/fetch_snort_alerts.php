<?php
header('Content-Type: application/json');

$file = '/var/log/snort/snort.alert.fast';
$linesToFetch = 20; // Number of latest alerts to fetch

if (file_exists($file) && is_readable($file)) {
    $lines = file($file);
    $latestAlerts = array_slice($lines, -$linesToFetch);
    $alerts = [];

    foreach ($latestAlerts as $line) {
        // Extract timestamp and alert details
        preg_match('/^(.*? )\[/', $line, $matches);
        $timestamp = $matches[1] ?? 'N/A';
        $alertDetails = trim(str_replace($timestamp, '', $line));

        $alerts[] = [
            'timestamp' => $timestamp,
            'details' => $alertDetails,
        ];
    }

    echo json_encode(['alerts' => $alerts]);
} else {
    echo json_encode(['error' => 'Unable to read Snort alert file.']);
}
?>
