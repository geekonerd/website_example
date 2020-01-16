<?php require_once 'core/core.php'; ?>

<html lang="it">

    <head>
        <title>Creo un SITO WEB da Zero #09 ⋆ ESEMPIO di FRONT-END (custom)</title>

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="assets/style.css">
    </head>

    <body>
        <?php if ($USER && $USER->perm < 3) : ?>
            <?php require_once 'admin.php'; ?>
        <?php endif; ?>

        <div v-cloak class="container" id="container">

            <?php require_once 'header.php'; ?>
            <?php require_once 'menu.php'; ?>

            <div class="alert alert-success" role="alert" v-if="show_success_message">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close" v-on:click="show_success_message = false">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="alert-heading">Completato!</h4>
                <p>L'operazione &egrave; avvenuta con successo.</p>
            </div>

            <div class="alert alert-danger" role="alert" v-if="show_error_message">
                <button type="button" class="close" data-dismiss="alert"
                        aria-label="Close" v-on:click="show_error_message = false">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="alert-heading">Attenzione!</h4>
                <p>Si &egrave; verificato un errore...</p>
                <hr><span class="text-monospace">{{ error }}</span>
            </div>