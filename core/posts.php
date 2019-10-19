<?php

/**
 * create post permalink
 * @param string $title
 */
function create_post_permalink($title) {
    return preg_replace('/[^A-Za-z0-9-]+/', '-', $title);
}

/**
 * get posts summary
 * @param int $offset
 * @global type $DB
 * @return mixed posts data or false
 */
function get_posts_summary($offset = 0) {
    global $DB;

    $_q = "SELECT p.id, p.title, p.summary, p.published, p.permalink, " .
            "u.username as author " .
            "FROM posts as p, users as u " .
            "WHERE p.author = u.id " .
            "ORDER BY p.published DESC LIMIT 5 OFFSET ?";
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
 * get post by permalink
 * @param string $permalink
 * @global type $DB
 * @return mixed post data or false
 */
function get_post_by_permalink($permalink = "") {
    global $DB;

    $_q = "SELECT p.id, p.title, p.content, p.published, u.username as author " .
            "FROM posts as p, users as u " .
            "WHERE p.author = u.id AND p.permalink = ?";
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
 * get post tags
 * @param int $id_post
 * @global type $DB
 * @return boolean
 */
function get_post_tags($id_post) {
    global $DB;

    $_q = "SELECT id_tag FROM posts_tags WHERE id_post = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('i', $id_post);
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
 * add new post
 * @param type $title
 * @param type $summary
 * @param type $content
 * @param type $author
 * @param type $permalink
 * @global type $DB
 * @return boolean
 */
function add_new_post($title, $summary, $content, $author, $permalink) {
    global $DB;

    // check if permalink already exists
    $rs = get_post_by_permalink($permalink);
    if (!$rs || !$rs->num_rows) {

        $_q = "INSERT INTO posts " .
                "(title, summary, content, published, author, permalink) " .
                "VALUES (?, ?, ?, now(), ?, ?)";
        $stmt = $DB->prepare($_q);
        $stmt->bind_param('sssis', $title, $summary, $content, $author, $permalink);
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
        while ($post = $rs->fetch_assoc()) {
            return $post["id"];
        }
    } else {
        return 0;
    }
}

/**
 * delete post
 * @param int $id_post
 * @global type $DB
 * @return boolean
 */
function delete_post($id_post) {
    global $DB;

    $_q = "DELETE FROM posts WHERE id = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('i', $id_post);
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
 * edit post
 * @param int $id
 * @param string $title
 * @param string $summary
 * @param string $content
 * @global type $DB
 * @return boolean
 */
function edit_post($id, $title, $summary, $content) {
    global $DB;

    $_q = "UPDATE posts SET title = COALESCE(?, title), " .
            "summary = COALESCE(?, summary), " .
            "content = COALESCE(?, content) WHERE id = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('sssi', $title, $summary, $content, $id);
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
 * add tag to post
 * @param int $id_post
 * @param int $id_tag
 * @global type $DB
 * @return boolean
 */
function add_tag_to_post($id_post, $id_tag) {
    global $DB;

    $_q = "INSERT INTO posts_tags (id_post, id_tag) VALUES (?, ?)";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('ii', $id_post, $id_tag);
    $stmt->execute();

    if ($stmt === false) {
        trigger_error('Error: ' . $DB->error, E_USER_ERROR);
        return false;
    } else {
        $stmt->close();
        return $id_tag;
    }
}

/**
 * delete post tags
 * @param int $id_post
 * @global type $DB
 * @return boolean
 */
function delete_post_tags($id_post) {
    global $DB;

    $_q = "DELETE FROM posts_tags WHERE id_post = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('i', $id_post);
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
 * add category to post
 * @param int $id_post
 * @param int $id_tag
 * @global type $DB
 * @return boolean
 */
function add_category_to_post($id_post, $id_category) {
    global $DB;

    $_q = "INSERT INTO posts_categories (id_post, id_category) VALUES (?, ?)";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('ii', $id_post, $id_category);
    $stmt->execute();

    if ($stmt === false) {
        trigger_error('Error: ' . $DB->error, E_USER_ERROR);
        return false;
    } else {
        $stmt->close();
        return $id_category;
    }
}

/**
 * delete post categories
 * @param int $id_post
 * @global type $DB
 * @return boolean
 */
function delete_post_categories($id_post) {
    global $DB;

    $_q = "DELETE FROM posts_categories WHERE id_post = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('i', $id_post);
    $stmt->execute();

    if ($stmt === false) {
        trigger_error('Error: ' . $DB->error, E_USER_ERROR);
        return false;
    } else {
        $stmt->close();
        return true;
    }
}
