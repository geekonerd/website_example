<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/categories.php';

$json = [];

/**
 * only authenticated user with at least editor level can add a new category
 */
if ($USER && $USER->perm < 3 && isset($_POST["title"]) &&
        isset($_POST["description"])) {

    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $cover = get_uploaded_file();
    $author = $USER->id;
    $permalink = create_category_permalink($title);

    $id_category = add_new_category($title, $description, $cover, $author, $permalink);

    $json["success"] = true;
    $json["data"] = [];
    $json["data"]["category"] = [];
    $json["data"]["category"]["id"] = $id_category;
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
