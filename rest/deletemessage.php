<?php

/**
 * require modules
 */
require_once '../core/core.php';
require_once '../core/messages.php';

$json = [];

/**
 * only authenticated user with at least editor level can delete a message
 */
/**
 * TODO: exercise no.2
 * - controllare i permessi dell'utente
 * - controllare i dati in $_POST (filtrare i parametri)
 * - eliminare lo specifico messaggio tramite il metodo delete_message()
 * - restituire lo stato dell'operazione via JSON
 */

/**
 * shutdown
 */
require_once '../core/shutdown.php';
header('Content-Type: application/json');
echo json_encode($json);
