<?php
$PAGE = "categories.php";
require_once 'structure/head.php';
?>

<main role="main" class="container mb-4" v-if="categories_loaded">

    <div class="row">
        <div class="col-md-8">
            <div class="row row-eq-height">
                <div class="col-sm-4 eq" v-for="elm in categories">
                    <div class="card mb-4">
                        <img v-bind:src="'assets/files/' + elm.cover"
                             class="card-img-top" alt="cover">
                        <div class="card-body bg-dark text-white">
                            <h5 class="card-title">{{ elm.title }}</h5>
                            <a v-bind:href="'/tutorial/ep8/category.php?p=' + elm.permalink"
                               class="stretched-link btn btn-secondary">VEDI</a>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="mt-4 py-3" v-if="show_more">
                <a class="btn btn-dark" href="#" v-on:click="load_more($event)">Carica altre</a>
            </nav>
        </div>
        
        <aside class="col-md-4">
            <?php require_once 'structure/widget_login.php'; ?>
        </aside>
    </div>

</main>

<?php require_once 'structure/foot.php'; ?>
<script type="text/javascript" src="assets/categories.js"></script>
<?php require_once 'structure/end.php'; ?>