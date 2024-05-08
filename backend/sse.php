<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$file = '../data/chat.json'; // Update this with the path to your file

function readAndUpdateFile($file) {
    clearstatcache(); // Clear the file status cache
    if (!file_exists($file)) {
        error_log("File not found: $file");
        return null;
    }
    $fileData = file_get_contents($file);
    if ($fileData === false) {
        error_log("Failed to read file: $file");
        return null;
    }
    $fileSize = filesize($file);
    return array('data' => $fileData, 'size' => $fileSize);
}

// Send initial data
$data = readAndUpdateFile($file);
if ($data !== null) {
    echo "data: " . json_encode($data) . "\n\n";
    flush();
}

// Keep the connection open
while (true) {
    $currentData = readAndUpdateFile($file);
    if ($currentData !== null) {
        $newData = json_encode($currentData);

        // Check if the file has been updated
        $lastData = $currentData;
        clearstatcache(); // Clear the file status cache
        while ($lastData === $currentData) {
            usleep(1000000); // Sleep for 1 second
            $currentData = readAndUpdateFile($file);
        }

        // Send updated data
        echo "data: " . $newData . "\n\n";
        flush();
    }
}
?>
