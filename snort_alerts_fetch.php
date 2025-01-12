<?php
$file = '/var/log/snort/snort.alert.fast';

if (file_exists($file)) {
    // Get the last 50 lines of the file
    $lines = array_slice(file($file), -50);
    echo nl2br(htmlspecialchars(implode("", $lines)));
} else {
    echo "No alerts found or file does not exist.";
}
?>

