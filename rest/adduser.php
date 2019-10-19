<?php

/**
 * require modules
 */
require_once '../core/core.php';

$json = [];

/**
 * only authenticated user with at least admin level can add a new user
 */
if ($USER && $USER->perm < 2 && isset($_POST["username"]) &&
        isset($_POST["password"]) && isset($_POST["role"])) {

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_NUMBER_INT);
    
    $id_user = add_new_user($username, $password, $role);

    $json["success"] = true;
    $json["data"] = [];
    $json["data"]["user"] = [];
    $json["data"]["user"]["id"] = $id_user;
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
