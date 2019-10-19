<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/tags.php';

$json = [];

/**
 * only authenticated user with at least editor level can add a new tag
 */
if ($USER && $USER->perm < 3 && isset($_POST["tag"])) {

    $tag = filter_input(INPUT_POST, 'tag', FILTER_SANITIZE_SPECIAL_CHARS);
    $permalink = create_tag_permalink($tag);

    $id_tag = add_new_tag($tag, $permalink);

    $json["success"] = true;
    $json["data"] = [];
    $json["data"]["tag"] = [];
    $json["data"]["tag"]["id"] = $id_tag;
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
