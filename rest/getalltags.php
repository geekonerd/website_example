<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/tags.php';

$json = [];

/**
 * retrieve all tags
 */
if (($tags = get_all_tags())) {
    $json["success"] = true;
    $json["data"] = [];
    $json["data"]["tags"] = [];
    while ($tag = $tags->fetch_assoc()) {
        $json["data"]["tags"][] = $tag;
    }
} else {
    $json["success"] = ìfalse;
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
