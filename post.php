<?php
require_once 'structure/head.php';
?>

<main role="main" class="container mb-4" v-if="post_loaded">
    <div class="row">
        <div class="col-md-8">
            <div class="mb-4" v-for="elm in post">
                <h2 class="mb-0" v-html="elm.title"></h2>
                <p class="font-italic">
                    <small class="text-muted">
                        {{ elm.published }}
                        da {{ elm.author }}
                        in <a v-for="category in categories"
                              v-bind:href="'/tutorial/ep8/category.php?p=' + category.permalink">
                            {{ category.title }}</a>
                    </small>
                </p>
                <div v-html="elm.content"></div>
            </div>
            <div class="container border border-info text-monospace rounded p-2">
                <a v-for="tag in tags" v-bind:href="'/tutorial/ep8/tag.php?p=' + tag.permalink">
                    #{{ tag.tag }}</a>
            </div>
        </div>

        <aside class="col-md-4">
            <?php require_once 'structure/widget_login.php'; ?>


        </aside>
    </div>
</main>

<?php require_once 'structure/foot.php'; ?>
<script type="text/javascript" src="assets/post.js"></script>
<?php require_once 'structure/end.php'; ?>