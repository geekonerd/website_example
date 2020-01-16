<?php

/**
 * require modules
 */
require_once '../core/core.php';

$json = [];

/**
 * retrieve all tags
 */
if (($roles = get_all_roles())) {
    $json["success"] = true;
    $json["data"] = [];
    $json["data"]["roles"] = [];
    while ($role = $roles->fetch_assoc()) {
        $json["data"]["roles"][] = $role;
    }
} else {
    $json["success"] = false;
}

/**
 * shutdown
 */
require_once '../core/shutdown.php';

/**
 * send back to client as JSON
 */
header('Content-Type: application/json');
echo json_encode($json);
