<?php $PAGE = "index.php";
require_once 'structure/head.php';
?>

<main role="main" class="container mb-4" v-if="posts_loaded">
    <div class="row">
        <div class="col-md-8">
            <div class="mb-4" v-for="elm in posts">
                <h2 class="mb-0" v-html="elm.title"></h2>
                <p class="font-italic">
                    <small class="text-muted">
                        {{ elm.published }}
                        da {{ elm.author }}
                        in <a v-for="category in elm.categories"
                              v-bind:href="'/tutorial/ep8/category.php?p=' + category.permalink">
                            {{ category.title }}</a>
                    </small>
                </p>
                <p v-html="elm.summary"></p>
                <a v-bind:href="'/tutorial/ep8/post.php?p=' + elm.permalink">
                    Continua &rAarr;</a>
            </div>
            <nav class="mt-4 py-3" v-if="show_more">
                <a class="btn btn-dark" href="#" v-on:click="load_more($event)">Carica altri</a>
            </nav>
        </div>

        <aside class="col-md-4">
            <?php require_once 'structure/widget_login.php'; ?>

            <div class="p-2 mt-4" v-if="tags_loaded">
                <h6>Cerca per tag</h6>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        v-for="tag in tags">
                        <a v-bind:href="'/tutorial/ep8/tag.php?p=' + tag.permalink">
                            #{{ tag.tag }}</a>
                        <span class="badge badge-muted badge-pill">{{ tag.weight }}</span>
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</main>

<?php require_once 'structure/foot.php'; ?>
<script type="text/javascript" src="assets/index.js"></script>
<?php require_once 'structure/end.php'; ?>