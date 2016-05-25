<?php

// Setting the default header 
header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("Access-Control-Allow-Origin: *");

// Get the Last Event ID - Check the Header or Get Method
$lastEventId = floatval(isset($_SERVER["HTTP_LAST_EVENT_ID"]) ? $_SERVER["HTTP_LAST_EVENT_ID"] : 0);
if ($lastEventId == 0) {
    $lastEventId = floatval(isset($_GET["lastEventId"]) ? $_GET["lastEventId"] : 0);
}
$lastEventId++;

// Start the messaging
echo ":" . str_repeat(" ", 2048) . "\n"; // 2 kB padding for IE
echo "retry: 2000\n";

echo "id: " . $lastEventId . "\n";
//echo "event: myEvent\n"; // Set here the custom event;
echo "data: Last Id is \n";
echo "data: " . $lastEventId . ";\n";
echo "\n";
echo "\n";

echo "id: " . ++$lastEventId . "\n";
echo "data: {\"userid\":1020}\n";
echo "\n";
echo "\n";

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    echo "id: " . ++$lastEventId . "\n";
    echo "data: Authorization - " . $_SERVER['HTTP_AUTHORIZATION'];
    echo "\n";
    echo "\n";
}


ob_flush();
flush();

