<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/messages.php';

$json = [];

/**
 * $_GET parameters
 */
$offset = 0;
if (array_key_exists('offset', $_GET)) {
    $offset = intval(htmlspecialchars($_GET["offset"]));
}

/**
 * retrieve messages
 */
if (($messages = get_messages($offset))) {
    $json["success"] = true;
    $json["data"] = [];
    $json["data"]["messages"] = [];
    while ($message = $messages->fetch_assoc()) {
        $json["data"]["messages"][] = $message;
    }
} else {
    $json["success"] = false;
}

/**
 * shutdown
 */
require_once '../core/shutdown.php';

/**
 * send back to client as JSON
 */
header('Content-Type: application/json');
echo json_encode($json);
