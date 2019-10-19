<?php

/* 
 * TODO: exercise no. 3
 * - completare i metodi presenti
 * - aggiungere eventuali metodi mancanti per funzionalita' aggiuntive
 */

/**
 * get messages
 * @param int $offset
 * @global type $DB
 * @return mixed messages data or false
 */
function get_messages($offset = 0) {
    global $DB;

    /**
     * TODO:
     * - recuperare gli ultimi 5 messaggi inseriti partendo dall'offset
     * - restituire i dati recuperati dal DB
     */
    
    return false;
}

/**
 * add new message
 * @param string $title
 * @param string $text
 * @param int $author
 * @global type $DB
 * @return boolean
 */
function add_new_message($title, $text, $author) {
    global $DB;

    /**
     * TODO:
     * - aggiungere il nuovo messaggio sul DB
     * - inserire anche il datetime $published
     * - restituire l'id del nuovo messaggio aggiunto
     */

    return false;
}

/**
 * delete message
 * @param int $id_message
 * @global type $DB
 * @return boolean
 */
function delete_message($id_message) {
    global $DB;

    /**
     * TODO:
     * - eliminare il messaggio identificato da $id_message
     * - tornare lo stato dell'operazione eseguita
     */
    
    return false;
}