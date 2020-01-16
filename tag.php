<?php
require_once 'structure/head.php';
?>

<main role="main" class="container mb-4" v-if="posts_loaded">
    <div class="row">
        <div class="col-md-8">
            <h3 class="mb-4">Articoli correlati:</h3>
            <p v-if="!posts.length">Nessun articolo associato presente.</p>
            <ul class="list-group">
                <li class="list-group-item" v-for="elm in posts">
                    <div class="d-flex w-100 justify-content-between">
                        <a v-bind:href="'/tutorial/ep8/post.php?p=' + elm.permalink">
                            <h5 class="mb-0" v-html="elm.title"></h5>
                        </a>
                        <small>{{ elm.published }}</small>
                    </div>
                </li>
            </ul>
        </div>
        
        <aside class="col-md-4">
            <?php require_once 'structure/widget_login.php'; ?>


        </aside>
    </div>
</main>

<?php require_once 'structure/foot.php'; ?>
<script type="text/javascript" src="assets/tag.js"></script>
<?php require_once 'structure/end.php'; ?>