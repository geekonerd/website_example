<?php

/**
 * create tag permalink
 * @param string $tag
 */
function create_tag_permalink($tag) {
    return preg_replace('/[^A-Za-z0-9-]+/', '-', $tag);
}

/**
 * get tag by permalink
 * @param type $permalink
 * @global type $DB
 * @return mixed tag data or false
 */
function get_tag_by_permalink($permalink = "") {
    global $DB;

    $_q = "SELECT id, tag, weight FROM tags WHERE permalink = ?";
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
 * get all tags
 * @global type $DB
 * @return mixed posts data or false
 */
function get_all_tags() {
    global $DB;

    $_q = "SELECT id, tag, weight, permalink FROM tags " .
            "ORDER BY weight DESC,tag ASC";
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
 * get posts by tag
 * @param string $tag
 * @param int $offset
 * @global type $DB
 * @return mixed posts data or false
 */
function get_posts_by_tag($tag = "", $offset = 0) {
    global $DB;

    $_q = "SELECT p.id, p.title, p.summary, p.published, p.permalink " .
            "FROM posts as p, tags as t, posts_tags as pt " .
            "WHERE t.id = pt.id_tag AND p.id = pt.id_post " .
            "AND t.permalink = ? ORDER BY p.published DESC LIMIT 5 OFFSET ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('si', $tag, $offset);
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
 * get post tags by permalink
 * @param string $permalink
 * @global type $DB
 * @return mixed posts data or false
 */
function get_post_tags_by_permalink($permalink = "") {
    global $DB;

    $_q = "SELECT t.id, t.tag, t.permalink FROM tags as t, posts as p, " .
            "posts_tags AS pt " .
            "WHERE t.id = pt.id_tag AND p.id = pt.id_post " .
            "AND p.permalink = ? ORDER BY t.tag ASC";
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
 * add new tag
 * @param string $tag
 * @param string $permalink
 * @param int $weight
 * @global type $DB
 * @return boolean
 */
function add_new_tag($tag, $permalink, $weight = 0) {
    global $DB;

    // check if permalink already exists
    $rs = get_tag_by_permalink($permalink);
    if (!$rs || !$rs->num_rows) {

        $_q = "INSERT INTO tags (tag, weight, permalink) VALUES (?, ?, ?)";
        $stmt = $DB->prepare($_q);
        $stmt->bind_param('sis', $tag, $weight, $permalink);
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
        while ($tag = $rs->fetch_assoc()) {
            return $tag["id"];
        }
    } else {
        return 0;
    }
}

/**
 * modify tag weight
 * @param int $id_tag
 * @param int $value
 * @global type $DB
 * @return boolean
 */
function modify_tag_weight($id_tag, $value) {
    global $DB;

    $_q = "UPDATE tags SET weight = weight + ? WHERE id = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('ii', $value, $id_tag);
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
 * delete tag
 * @param int $id_tag
 * @global type $DB
 * @return boolean
 */
function delete_tag($id_tag) {
    global $DB;

    $_q = "DELETE FROM tags WHERE id = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('i', $id_tag);
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
 * edit tag
 * @param int $id
 * @param string $tag
 * @param int $weight
 * @global type $DB
 * @return boolean
 */
function edit_tag($id, $tag, $weight) {
    global $DB;

    $_q = "UPDATE tags SET tag = COALESCE(?, tag), " .
            "weight = COALESCE(?, weight) WHERE id = ?";
    $stmt = $DB->prepare($_q);
    $stmt->bind_param('sii', $tag, $weight, $id);
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
