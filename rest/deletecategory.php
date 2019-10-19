<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/categories.php';

$json = [];

/**
 * only authenticated user with at least editor level can delete a category
 */
if ($USER && $USER->perm < 3 && isset($_POST["category"])) {

    $id_category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);

    $result = delete_category($id_category);

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
