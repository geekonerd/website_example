<?php

/**
 * create category permalink
 * @param string $category
 */
function create_category_permalink($category) {
    return preg_replace('/[^A-Za-z0-9-]+/', '-', $category);
}

/**
 * get categories
 * @param int $offset
 * @global type $DB
 * @return mixed categories data or false
 */
function get_categories($offset = 0) {
    global $DB;

    $_q = "SELECT id, title, cover, permalink FROM categories " .
            "ORDER BY published DESC LIMIT 10 OFFSET ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('i', $offset);
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
 * get category by permalink
 * @param string $permalink
 * @global type $DB
 * @return mixed posts data or false
 */
function get_category_by_permalink($permalink = "") {
    global $DB;

    $_q = "SELECT c.id, c.title, c.cover, c.description, c.published, " .
            "u.username as author " .
            "FROM categories as c, users as u " .
            "WHERE c.author = u.id AND c.permalink = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('s', $permalink);
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
 * get latest posts by category
 * @param string $permalink
 * @param int $offset
 * @global type $DB
 * @return mixed posts data or false
 */
function get_latest_posts_by_category($permalink = '') {
    global $DB;

    $_q = "SELECT p.title, p.published, p.permalink " .
            "FROM posts as p, categories as c, users as u, " .
            "posts_categories as pc " .
            "WHERE c.id = pc.id_category AND p.id = pc.id_post " .
            "AND c.author = u.id AND c.permalink = ? " .
            "ORDER BY p.published DESC LIMIT 15";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('s', $permalink);
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
 * get post categories by permalink
 * @param string $permalink
 * @global type $DB
 * @return mixed posts data or false
 */
function get_post_categories_by_permalink($permalink = "") {
    global $DB;

    $_q = "SELECT c.id, c.title, c.permalink FROM categories as c, posts as p, " .
            "posts_categories AS pc " .
            "WHERE c.id = pc.id_category AND p.id = pc.id_post " .
            "AND p.permalink = ? ORDER BY c.title ASC";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('s', $permalink);
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
 * add new category
 * @param string $title
 * @param string $description
 * @param string $cover
 * @param int $author
 * @param string $permalink
 * @global type $DB
 * @return boolean
 */
function add_new_category($title, $description, $cover, $author, $permalink) {
    global $DB;

    // check if permalink already exists
    $rs = get_category_by_permalink($permalink);
    if (!$rs || !$rs->num_rows) {

        $_q = "INSERT INTO categories " .
                "(title, description, cover, published, author, permalink) " .
                "VALUES (?, ?, ?, now(), ?, ?)";
        $stmt = $DB->prepare($_q);
        $stmt->bind_param('sssis', $title, $description, $cover, $author, $permalink);
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
        while ($category = $rs->fetch_assoc()) {
            return $category["id"];
        }
    } else {
        return 0;
    }
}

/**
 * delete category
 * @param int $id_category
 * @global type $DB
 * @return boolean
 */
function delete_category($id_category) {
    global $DB;

    $_q = "DELETE FROM categories WHERE id = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('i', $id_category);
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
 * edit category
 * @param int $id
 * @param string $title
 * @param string $description
 * @param string $cover
 * @global type $DB
 * @return boolean
 */
function edit_category($id, $title, $description, $cover) {
    global $DB;

    $_q = "UPDATE categories SET title = COALESCE(?, title), " .
            "description = COALESCE(?, description), " .
            "cover = COALESCE(?, cover) WHERE id = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('sssi', $title, $description, $cover, $id);
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
