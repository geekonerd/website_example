<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/tags.php';

$json = [];

/**
 * only authenticated user with at least editor level can edit a tag
 */
if ($USER && $USER->perm < 3 && isset($_POST["id"])) {

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $tag = isset($_POST["tag"]) ?
            filter_input(INPUT_POST, 'tag', FILTER_SANITIZE_SPECIAL_CHARS) : null;
    $weight = isset($_POST["weight"]) ?
            filter_input(INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_INT) : null;

    $result = edit_tag($id, $tag, $weight);

    $json["success"] = $result ? true : false;
    $json["edits"] = $result;
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
