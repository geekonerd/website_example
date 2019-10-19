<?php

/**
 * require modules
 */
require_once '../core/core.php';

$json = [];

/**
 * only authenticated user with at least admin level can delete a user
 */
if ($USER && $USER->perm < 2 && isset($_POST["user"])) {

    $id_user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_NUMBER_INT);

    $result = delete_user($id_user);

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
