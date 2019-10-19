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
$permalink = "";
if (array_key_exists('p', $_GET)) {
    $permalink = htmlspecialchars($_GET["p"]);
}

/**
 * retrieve latest posts by category permalink
 */
if (($posts = get_latest_posts_by_category($permalink))) {
    $json["success"] = true;
    $json["data"] = [];
    $json["data"]["posts"] = [];
    while ($post = $posts->fetch_assoc()) {
        $json["data"]["posts"][] = $post;
    }

    if (($category = get_category_by_permalink($permalink))) {
        $json["data"]["category"] = [];
        while ($cat = $category->fetch_assoc()) {
            $json["data"]["category"][] = $cat;
        }
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
