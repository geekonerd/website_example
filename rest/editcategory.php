<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/categories.php';

$json = [];

/**
 * only authenticated user with at least editor level can edit a category
 */
if ($USER && $USER->perm < 3 && isset($_POST["id"])) {

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $title = isset($_POST["title"]) ?
            filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS) : null;
    $description = isset($_POST["description"]) ?
            filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS) : null;
    $cover = (isset($_FILES["file"])) ? get_uploaded_file() : null;

    $result = edit_category($id, $title, $description, $cover);

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
