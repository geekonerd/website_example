<?php

/**
 * require modules
 */
require_once '../core/core.php';

$json = [];

/**
 * only authenticated user with at least admin level can edit a user
 */
if ($USER && $USER->perm < 2 && isset($_POST["id"])) {

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $username = isset($_POST["username"]) ?
            filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) : null;
    $password = isset($_POST["password"]) ?
            filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) : null;
    $role = isset($_POST["role"]) ?
            filter_input(INPUT_POST, 'role', FILTER_SANITIZE_NUMBER_INT) : nul;

    $result = edit_user($id, $username, $password, $role);

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
