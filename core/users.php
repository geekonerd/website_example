<?php

$USER = false;

/**
 * get user
 * @param string $username
 * @param string $password
 * @global type $DB
 * @return mixed user data or false
 */
function get_user($username = null, $password = null) {
    global $DB;

    $_q = "SELECT u.id, u.username, u.role as perm, r.role FROM users as u, " .
            "roles as r " .
            "WHERE u.role = r.id AND u.username = ? AND u.password = MD5(?)";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();

    if ($stmt === false) {
        trigger_error('Error: ' . $DB->error, E_USER_ERROR);
        return false;
    } else {
        $result = $stmt->get_result();
        while (($rs = $result->fetch_object())) {
            $_SESSION['user'] = $rs;
        }
        $stmt->close();
        return (array_key_exists('user', $_SESSION)) ? $_SESSION['user'] : false;
    }
}

/**
 * get user by username
 * @param string $username
 * @global type $DB
 * @return mixed user data or false
 */
function get_user_by_username($username = null) {
    global $DB;

    $_q = "SELECT id FROM users WHERE username = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('s', $username);
    $stmt->execute();

    if ($stmt === false) {
        trigger_error('Error: ' . $DB->error, E_USER_ERROR);
        return false;
    } else {
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }
}

/**
 * add new user
 * @param string $username
 * @param string $password
 * @param int $role
 * @global type $DB
 * @return boolean
 */
function add_new_user($username, $password, $role) {
    global $DB;

    // check if permalink already exists
    $rs = get_user_by_username($username);
    if (!$rs || !$rs->num_rows) {

        $_q = "INSERT INTO users (username, password, role) VALUES (?, MD5(?), ?)";
        $stmt = $DB->prepare($_q);
        $stmt->bind_param('ssi', $username, $password, $role);
        $stmt->execute();

        if ($stmt === false) {
            trigger_error('Error: ' . $DB->error, E_USER_ERROR);
            return false;
        } else {
            $result = $stmt->insert_id;
            $stmt->close();
            return $result;
        }
    } elseif ($rs) {
        while ($user = $rs->fetch_assoc()) {
            return $user["id"];
        }
    } else {
        return 0;
    }
}

/**
 * delete user
 * @param int $id_user
 * @global type $DB
 * @return boolean
 */
function delete_user($id_user) {
    global $DB;

    $_q = "DELETE FROM users WHERE id = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('i', $id_user);
    $stmt->execute();

    if ($stmt === false) {
        trigger_error('Error: ' . $DB->error, E_USER_ERROR);
        return false;
    } else {
        $stmt->close();
        return true;
    }
}

/**
 * edit role
 * @param int $id
 * @param string $username
 * @param string $password
 * @param int $role
 * @global type $DB
 * @return boolean
 */
function edit_user($id, $username, $password, $role) {
    global $DB;

    $_q = "UPDATE users SET username = COALESCE(?, username), " .
            "password = COALESCE(MD5(?), password), " .
            "role = COALESCE(?, role) WHERE id = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('sssi', $username, $password, $role, $id);
    $stmt->execute();

    if ($stmt === false) {
        trigger_error('Error: ' . $DB->error, E_USER_ERROR);
        return false;
    } else {
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }
}

/**
 * get all roles
 * @param type $role
 * @return boolean
 */
function get_all_roles() {
    global $DB;

    $_q = "SELECT id, role FROM roles ORDER BY role ASC";
    $stmt = $DB->prepare($_q);
    $stmt->execute();

    if ($stmt === false) {
        trigger_error('Error: ' . $DB->error, E_USER_ERROR);
        return false;
    } else {
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }
}

/**
 * get role
 * @param string $role
 * @global type $DB
 * @return boolean
 */
function get_role($role) {
    global $DB;

    $_q = "SELECT id, role FROM roles WHERE role = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('s', $role);
    $stmt->execute();

    if ($stmt === false) {
        trigger_error('Error: ' . $DB->error, E_USER_ERROR);
        return false;
    } else {
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }
}

/**
 * add new role
 * @param string $role
 * @return boolean|int
 */
function add_new_role($role) {
    global $DB;

    // check if role already exists
    $rs = get_role($role);
    if (!$rs || !$rs->num_rows) {

        $_q = "INSERT INTO roles (role) VALUES (?)";
        $stmt = $DB->prepare($_q);
        $stmt->bind_param('s', $role);
        $stmt->execute();

        if ($stmt === false) {
            trigger_error('Error: ' . $DB->error, E_USER_ERROR);
            return false;
        } else {
            $result = $stmt->insert_id;
            $stmt->close();
            return $result;
        }
    } elseif ($rs) {
        while ($role = $rs->fetch_assoc()) {
            return $role["id"];
        }
    } else {
        return 0;
    }
}

/**
 * delete role
 * @param int $id_role
 * @global type $DB
 * @return boolean
 */
function delete_role($id_role) {
    global $DB;

    $_q = "DELETE FROM roles WHERE id = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('i', $id_role);
    $stmt->execute();

    if ($stmt === false) {
        trigger_error('Error: ' . $DB->error, E_USER_ERROR);
        return false;
    } else {
        $stmt->close();
        return true;
    }
}

/**
 * edit role
 * @param int $id
 * @param string $role
 * @global type $DB
 * @return boolean
 */
function edit_role($id, $role) {
    global $DB;

    $_q = "UPDATE roles SET role = COALESCE(?, role) WHERE id = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('si', $role, $id);
    $stmt->execute();

    if ($stmt === false) {
        trigger_error('Error: ' . $DB->error, E_USER_ERROR);
        return false;
    } else {
        $result = $stmt->affected_rows;
        $stmt->close();
        return $result;
    }
}

/**
 * logout
 */
if (isset($_POST["logout"])) {
    unset($_SESSION["user"]);
}

/**
 * load user from SESSION
 */ elseif (isset($_SESSION["user"])) {
    $USER = $_SESSION["user"];
}

/**
 * log in by username and password
 */ elseif (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $USER = get_user($username, $password);
}
