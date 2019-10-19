<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/posts.php';
require_once '../core/categories.php';
require_once '../core/tags.php';

$json = [];

/**
 * $_GET parameters
 */
$permalink = "";
if (array_key_exists('p', $_GET)) {
    $permalink = htmlspecialchars($_GET["p"]);
}

/**
 * retrieve post by permalink
 */
if (($posts = get_post_by_permalink($permalink))) {
    $json["success"] = true;
    $json["data"] = [];
    $json["data"]["posts"] = [];
    while ($post = $posts->fetch_assoc()) {
        $json["data"]["posts"][] = $post;
    }
    if (($tags = get_post_tags_by_permalink($permalink))) {
        $json["data"]["tags"] = [];
        while ($tag = $tags->fetch_assoc()) {
            $json["data"]["tags"][] = $tag;
        }
    }
    if (($categories = get_post_categories_by_permalink($permalink))) {
        $json["data"]["categories"] = [];
        while ($category = $categories->fetch_assoc()) {
            $json["data"]["categories"][] = $category;
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
