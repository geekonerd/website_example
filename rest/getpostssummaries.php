<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/posts.php';
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
 * retrieve posts summaries
 */
if (($posts = get_posts_summary($offset))) {
    $json["success"] = true;
    $json["data"] = [];
    $json["data"]["posts"] = [];
    while ($post = $posts->fetch_assoc()) {
        if (($categories = get_post_categories_by_permalink($post["permalink"]))) {
            while ($category = $categories->fetch_assoc()) {
                $post["categories"][] = $category;
            }
        }
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
