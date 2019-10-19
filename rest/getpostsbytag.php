<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/tags.php';

$json = [];

/**
 * $_GET parameters
 */
$tag = "";
if (array_key_exists('t', $_GET)) {
    $tag = htmlspecialchars($_GET["t"]);
}
$offset = 0;
if (array_key_exists('offset', $_GET)) {
    $offset = intval(htmlspecialchars($_GET["offset"]));
}

/**
 * retrieve all posts by tag
 */
if (($posts = get_posts_by_tag($tag, $offset))) {
    $json["success"] = true;
    $json["data"] = [];
    $json["data"]["posts"] = [];
    while ($post = $posts->fetch_assoc()) {
        $json["data"]["posts"][] = $post;
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
