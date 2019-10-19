<?php

$DB = null;

/**
 * connect to DB
 * @global type $DB
 */
function connect_to_db() {
    global $DB;

    $DBServer = ''; // IP
    $DBUser = '';   // username
    $DBPass = '';   // password
    $DBName = '';   // schema name
    $DB = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
    if ($DB->connect_error) {
        trigger_error('Database connection failed: ' . $DB->connect_error, E_USER_ERROR);
        exit();
    }
}

/**
 * close connection
 * @global type $DB
 */
function close_connection() {
    global $DB;

    $DB->close();
}

/**
 * connect to DB
 */
connect_to_db();
