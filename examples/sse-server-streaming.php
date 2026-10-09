<?php

ob_start();

// Setting the default header 
header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("Access-Control-Allow-Origin: *");

ob_flush();
flush();

// Get the Last Event ID - Check the Header or Get Method
$lastEventId = floatval(isset($_SERVER["HTTP_LAST_EVENT_ID"]) ? $_SERVER["HTTP_LAST_EVENT_ID"] : 0);
if ($lastEventId == 0) {
    $lastEventId = floatval(isset($_GET["lastEventId"]) ? $_GET["lastEventId"] : 0);
}

// Start the messaging
echo ":" . str_repeat(" ", 2048) . "\n"; // 2 kB padding for IE
echo "retry: 2000\n";

for ($i = 0; $i<100; $i++) {
    echo "id: " . ++$lastEventId . "\n";
    echo "event: first\n";
    echo "data: Last Id is \n";
    echo "data: " . $lastEventId . str_repeat(" ", 2048) . ";\n";
    echo "\n";
    echo "\n";

    echo "id: " . ++$lastEventId . "\n";
    echo "event: second\n";
    echo "data: {\"userid\":1020}\n";
    echo "\n";
    echo "\n";
    sleep(1);
    ob_flush();
    flush();
}

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    echo "id: " . ++$lastEventId . "\n";
    echo "data: Authorization - " . $_SERVER['HTTP_AUTHORIZATION'];
    echo "\n";
    echo "\n";
}


ob_flush();
flush();

