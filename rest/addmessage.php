<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/messages.php';

$json = [];

/**
 * only authenticated user with at least guest level can add a new message
 */

/**
 * TODO: exercise no.1
 * - controllare i permessi dell'utente
 * - controllare i dati in $_POST (filtrare i parametri)
 * - aggiungere il messaggio tramite il metodo add_new_message()
 * - restituire l'$id_message tramite JSON
 */


/**
 * shutdown
 */
require_once '../core/shutdown.php';
header('Content-Type: application/json');
echo json_encode($json);
