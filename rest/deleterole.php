<?php

/**
 * require modules
 */
require_once '../core/core.php';

$json = [];

/**
 * only authenticated user with at least admin level can delete a role
 */
if ($USER && $USER->perm < 2 && isset($_POST["role"])) {

    $id_role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_NUMBER_INT);

    $result = delete_role($id_role);

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
