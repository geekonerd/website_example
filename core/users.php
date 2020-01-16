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
 * get user by cookies
 * @param string $username
 * @param string $rnd_pwd
 * @param string $rnd_slc
 * @global type $DB
 * @return mixed user data or false
 */
function get_user_by_cookies($username, $rnd_pwd, $rnd_slc) {
    global $DB;

    $_q = "SELECT u.id, u.username, u.role as perm, r.role FROM users as u, " .
            "roles as r WHERE u.role = r.id AND u.username = ? AND " .
            "u.rnd_pwd = MD5(?) AND u.rnd_slc = MD5(?) AND ".
            "expiration >= UNIX_TIMESTAMP()";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('sss', $username, $rnd_pwd, $rnd_slc);
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
 * edit cookies login
 * @param int $id
 * @param string $rnd_pwd
 * @param string $rnd_slc
 * @param int $expiration
 * @global type $DB
 * @return boolean
 */
function edit_cookies_login($id, $rnd_pwd, $rnd_slc, $expiration) {
    global $DB;

    $stmt = false;
    if (null === $rnd_pwd && null === $rnd_slc && null == $expiration) {
        $_q = "UPDATE users SET rnd_pwd = null, rnd_slc = null, " .
                "expiration = null WHERE id = ?";
        $stmt = $DB->prepare($_q);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    } else {
        $_q = "UPDATE users SET rnd_pwd = COALESCE(MD5(?), rnd_pwd), " .
                "rnd_slc = COALESCE(MD5(?), rnd_slc), " .
                "expiration = COALESCE(?, expiration) WHERE id = ?";
        $stmt = $DB->prepare($_q);
        $stmt->bind_param('ssii', $rnd_pwd, $rnd_slc, $expiration, $id);
        $stmt->execute();
    }

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
    if (isset($_SESSION["user"])) {
        $id = $_SESSION["user"]->id;
        unset($_SESSION["user"]);
        edit_cookies_login($id, null, null, null);
    }
    setcookie("remember", "", time() - 3600);
    setcookie("random_password", "", time() - 3600);
    setcookie("random_selector", "", time() - 3600);
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

    /* remember user for 30 days */
    if (isset($_POST["remember"])) {
        $expiration_time = time() + (86400 * 30);

        // set main cookie
        setcookie("remember", $username, $expiration_time);

        // set random password
        $random_password = random_str(16);
        setcookie("random_password", $random_password, $expiration_time);

        // set random selector
        $random_selector = random_str(16);
        setcookie("random_selector", $random_selector, $expiration_time);

        // update db
        edit_cookies_login($USER->id, $random_password, $random_selector,
                $expiration_time);
    }
}

/**
 * log in by cookies
 */ elseif (isset($_COOKIE["remember"]) && isset($_COOKIE["random_password"]) &&
        isset($_COOKIE["random_selector"])) {

    $username = filter_input(INPUT_COOKIE, 'remember', FILTER_SANITIZE_STRING);
    $random_password = filter_input(INPUT_COOKIE, 'random_password', FILTER_SANITIZE_STRING);
    $random_selector = filter_input(INPUT_COOKIE, 'random_selector', FILTER_SANITIZE_STRING);

    $USER = get_user_by_cookies($username, $random_password, $random_selector);
    if (!$USER) {
        setcookie("remember", "", time() - 3600);
        setcookie("random_password", "", time() - 3600);
        setcookie("random_selector", "", time() - 3600);
    }
}