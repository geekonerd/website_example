<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/posts.php';
require_once '../core/tags.php';

$json = [];

/**
 * only authenticated user with at least editor level can delete a post
 */
if ($USER && $USER->perm < 3 && isset($_POST["post"])) {

    $id_post = filter_input(INPUT_POST, 'post', FILTER_SANITIZE_NUMBER_INT);

    $post_tags = get_post_tags($id_post);
    while ($tag = $post_tags->fetch_assoc()) {
        modify_tag_weight($tag["id_tag"], -1);
    }

    $result = delete_post_tags($id_post);
    $result *= delete_post_categories($id_post);
    $result *= delete_post($id_post);

    $json["success"] = $result;
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
