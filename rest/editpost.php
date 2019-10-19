<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/posts.php';
require_once '../core/tags.php';

$json = [];

/**
 * only authenticated user with at least editor level can edit a post
 */
if ($USER && $USER->perm < 3 && isset($_POST["id"])) {

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $title = isset($_POST["title"]) ?
            filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS) : null;
    $summary = isset($_POST["summary"]) ?
            filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_SPECIAL_CHARS) : null;
    $content = isset($_POST["content"]) ?
            filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS) : null;

    $result = edit_post($id, $title, $summary, $content);

    $id_tags = [];
    if (isset($_POST["tags"])) {
        $tags = filter_input(INPUT_POST, 'tags', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (is_array($tags)) {

            $post_tags = get_post_tags($id);
            while ($tag = $post_tags->fetch_assoc()) {
                modify_tag_weight($tag["id_tag"], -1);
            }
            delete_post_tags($id);

            foreach ($tags as $tag) {
                $tag_permalink = create_tag_permalink($tag);
                $id_tag = add_new_tag($tag, $tag_permalink);
                $id_tags[] = add_tag_to_post($id, $id_tag);
                modify_tag_weight($id_tag, 1);
            }
        }
    }

    $id_categories = [];
    if (isset($_POST["categories"])) {
        $categories = filter_input(INPUT_POST, 'categories', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (is_array($categories)) {
            delete_post_categories($id);
            foreach ($categories as $id_category) {
                $id_categories[] = add_category_to_post($id, $id_category);
            }
        }
    }

    $json["success"] = $result || sizeof($id_categories) || sizeof($id_tags) ? true : false;
    $json["edits"] = $result + sizeof($id_categories) + sizeof($id_tags);
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
