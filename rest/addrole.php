<?php

/**
 * require modules
 */
require_once '../core/core.php';

$json = [];

/**
 * only authenticated user with at least admin level can add a new role
 */
if ($USER && $USER->perm < 2 && isset($_POST["role"])) {

    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);

    $id_role = add_new_role($role);

    $json["success"] = true;
    $json["data"] = [];
    $json["data"]["role"] = [];
    $json["data"]["role"]["id"] = $id_role;
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
