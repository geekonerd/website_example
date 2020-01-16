<?php
require_once 'structure/head.php';
?>

<main role="main" class="container mb-4" v-if="category_loaded">
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

        <aside class="col-md-4" v-for="elm in category">
            <?php require_once 'structure/widget_login.php'; ?>

            <div class="card mt-3">
                <div class="card-header">
                    <div class="d-flex flex-row">
                        <h6 class="mr-auto pt-1 mb-0" v-html="elm.title"></h6>
                        <?php if ($USER && $USER->perm < 3) : ?>
                            <button type="button" class="btn btn-info mr-1"
                                    v-on:click="show_editor('edit')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <div id="category_editor" class="modal fade text-left" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">MODIFICA CATEGORIA</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form accept-charset="multipart/form-data">
                                                <input type="hidden" name="id" :value="elm.id"/>
                                                <div class="form-group">
                                                    <label for="categoryTitle">TITOLO</label>
                                                    <input type="text" name="title" :value="elm.title" class="form-control" id="categoryTitle" aria-describedby="categoryTitleHelp">
                                                    <small id="categoryTitleHelp" class="form-text text-muted">Il titolo della categoria.</small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="categoryDescription">DESCRIZIONE</label>
                                                    <textarea name="description" :value="elm.description" class="form-control" rows="5" id="categoryDescription" aria-describedby="categoryDescriptionHelp"></textarea>
                                                    <small id="categoryDescriptionHelp" class="form-text text-muted">La descrizione della categoria.</small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="categoryFile">COVER</label>
                                                    <input type="file" class="form-control-file" id="categoryFile" name="file" placeholder="cover" aria-describedby="categoryFileHelp">
                                                    <small id="categoryFileHelp" class="form-text text-muted">L'immagine di copertina della categoria.</small>
                                                </div>
                                            </form>
                                            <div class="alert alert-danger" role="alert" v-if="error">
                                                Si &egrave; verificato un errore, riprovare pi&ugrave; tardi.
                                                <hr><span class="text-monospace">{{ error }}</span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button v-on:click="edit_category()" type="button" class="btn btn-primary">SALVA</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CHIUDI</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger"
                                    v-on:click="delete_category(elm.id)">
                                <i class="fa fa-trash"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body text-center">
                    <img v-bind:src="'assets/files/' + elm.cover" alt="cover" />
                    <p class="mb-1" v-html="elm.description"></p>
                </div>
                <div class="card-footer text-muted">
                    <small>
                        da {{ elm.author }}, {{ elm.published }}
                    </small>
                </div>

            </div>
        </aside>
    </div>
</main>

<?php require_once 'structure/foot.php'; ?>
<script type="text/javascript" src="assets/category.js"></script>
<?php require_once 'structure/end.php'; ?>