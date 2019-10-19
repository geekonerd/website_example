<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/tags.php';

$json = [];

/**
 * only authenticated user with at least editor level can delete a tag
 */
if ($USER && $USER->perm < 3 && isset($_POST["tag"])) {

    $id_tag = filter_input(INPUT_POST, 'tag', FILTER_SANITIZE_NUMBER_INT);

    $result = delete_tag($id_tag);

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
