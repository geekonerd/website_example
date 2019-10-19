<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/categories.php';

$json = [];

/**
 * $_GET parameters
 */
$offset = 0;
if (array_key_exists('offset', $_GET)) {
    $offset = intval(htmlspecialchars($_GET["offset"]));
}

/**
 * retrieve categories
 */
if (($categories = get_categories($offset))) {
    $json["success"] = true;
    $json["data"] = [];
    $json["data"]["categories"] = [];
    while ($category = $categories->fetch_assoc()) {
        $json["data"]["categories"][] = $category;
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
