<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/posts.php';
require_once '../core/tags.php';

$json = [];

/**
 * only authenticated user with at least editor level can add a new post
 */
if ($USER && $USER->perm < 3 && isset($_POST["title"]) &&
        isset($_POST["summary"]) && isset($_POST["content"])) {

    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $summary = filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
    $author = $USER->id;
    $permalink = create_post_permalink($title);

    $id_post = add_new_post($title, $summary, $content, $author, $permalink);

    $id_tags = [];
    if (isset($_POST["tags"])) {
        $tags = filter_input(INPUT_POST, 'tags', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (is_array($tags)) {
            foreach ($tags as $tag) {
                $tag_permalink = create_tag_permalink($tag);
                $id_tag = add_new_tag($tag, $tag_permalink);
                $id_tags[] = add_tag_to_post($id_post, $id_tag);
                modify_tag_weight($id_tag, 1);
            }
        }
    }

    $id_categories = [];
    if (isset($_POST["categories"])) {
        $categories = filter_input(INPUT_POST, 'categories', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (is_array($categories)) {
            foreach ($categories as $id_category) {
                $id_categories[] = add_category_to_post($id_post, $id_category);
            }
        }
    }

    $json["success"] = true;
    $json["data"] = [];
    $json["data"]["post"] = [];
    $json["data"]["post"]["id"] = $id_post;
    $json["data"]["post"]["tags"] = $id_tags;
    $json["data"]["post"]["categories"] = $id_categories;
} else {
    $json["success"] = false;
    $json["code"] = -1;
    $json["error"] = "unauthorized";
}

/**
 * shutdown
 */
require_once '../core/shutdown.php';
header('Content-Type: application/json');
echo json_encode($json);
