<div v-cloak id="admin">
    <div class="bg-dark p-2 text-center">
        <button type="button" class="btn btn-success btn-sm"
                v-on:click="show_editor('post')">
            <i class="fa fa-file"></i>
        </button>
        <div id="admin_editor_post" class="modal fade text-left" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">CREA NUOVO POST</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="postTitle">TITOLO</label>
                                <input type="text" name="title" placeholder="title" class="form-control" id="postTitle" aria-describedby="postTitleHelp">
                                <small id="postTitleHelp" class="form-text text-muted">Il titolo del nuovo post da aggiungere.</small>
                            </div>
                            <div class="form-group">
                                <label for="postSummary">SOMMARIO</label>
                                <textarea name="summary" placeholder="summary" class="form-control" rows="3" id="postSummary" aria-describedby="postSummaryHelp"></textarea>
                                <small id="postSummaryHelp" class="form-text text-muted">Un breve riassunto del nuovo post da aggiungere.</small>
                            </div>
                            <div class="form-group">
                                <label for="postContent">CONTENUTO</label>
                                <textarea name="content" placeholder="content" class="form-control" rows="5" id="postContent" aria-describedby="postContentHelp"></textarea>
                                <small id="postContentHelp" class="form-text text-muted">Il contenuto del nuovo post da aggiungere.</small>
                            </div>
                            <div class="form-group">
                                <label for="postTags">TAGS</label>
                                <select class="form-control form-control-lg" name="tags[]" id="postTags" aria-describedby="postTagsHelp" multiple>
                                    <option :value="elm.tag" v-for="elm in tags">{{ elm.tag }}</option>
                                </select>
                                <small id="postTagsHelp" class="form-text text-muted">Tag associati al nuovo post da aggiungere.</small>
                            </div>
                            <div class="form-group">
                                <label for="postCategories">CATEGORIE</label>
                                <select class="form-control form-control-lg" name="categories[]" id="postCategories" aria-describedby="postCategoriesHelp" multiple>
                                    <option :value="elm.id" v-for="elm in categories">{{ elm.title }}</option>
                                </select>
                                <small id="postCategoriesHelp" class="form-text text-muted">Categorie associate al nuovo post da aggiungere.</small>
                            </div>
                        </form>
                        <div class="alert alert-danger" role="alert" v-if="error">
                            Si &egrave; verificato un errore, riprovare pi&ugrave; tardi.
                            <hr><span class="text-monospace">{{ error }}</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-on:click="create_new()" type="button" class="btn btn-primary">SALVA</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CHIUDI</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-success btn-sm"
                v-on:click="show_editor('category')">
            <i class="fa fa-bookmark"></i>
        </button>
        <div id="admin_editor_category" class="modal fade text-left" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">CREA NUOVA CATEGORIA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form accept-charset="multipart/form-data">
                            <div class="form-group">
                                <label for="categoryTitle">TITOLO</label>
                                <input type="text" name="title" placeholder="title" class="form-control" id="categoryTitle" aria-describedby="categoryTitleHelp">
                                <small id="categoryTitleHelp" class="form-text text-muted">Il titolo della nuova categoria da aggiungere.</small>
                            </div>
                            <div class="form-group">
                                <label for="categoryDescription">DESCRIZIONE</label>
                                <textarea name="description" placeholder="description" class="form-control" rows="5" id="categoryDescription" aria-describedby="categoryDescriptionHelp"></textarea>
                                <small id="categoryDescriptionHelp" class="form-text text-muted">Una descrizione della nuova categoria da aggiungere.</small>
                            </div>
                            <div class="form-group">
                                <label for="categoryFile">COVER</label>
                                <input type="file" class="form-control-file" id="categoryFile" name="file" placeholder="cover" aria-describedby="categoryFileHelp">
                                <small id="categoryFileHelp" class="form-text text-muted">Una immagine di copertina per la nuova categoria da aggiungere.</small>
                            </div>
                        </form>
                        <div class="alert alert-danger" role="alert" v-if="error">
                            Si &egrave; verificato un errore, riprovare pi&ugrave; tardi.
                            <hr><span class="text-monospace">{{ error }}</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-on:click="create_new()" type="button" class="btn btn-primary">SALVA</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CHIUDI</button>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-success btn-sm"
                v-on:click="show_editor('tag')">
            <i class="fa fa-hashtag"></i>
        </button>
        <div id="admin_editor_tag" class="modal fade text-left" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">CREA NUOVO TAG</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="inputTag">TAG</label>
                                <input type="text" name="tag" placeholder="tag" class="form-control" id="inputTag" aria-describedby="inputTagHelp">
                                <small id="inputTagHelp" class="form-text text-muted">Il nome del nuovo tag da aggiungere.</small>
                            </div>
                        </form>
                        <div class="alert alert-danger" role="alert" v-if="error">
                            Si &egrave; verificato un errore, riprovare pi&ugrave; tardi.
                            <hr><span class="text-monospace">{{ error }}</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-on:click="create_new()" type="button" class="btn btn-primary">SALVA</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CHIUDI</button>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($USER->perm < 2) : ?>
            <button type="button" class="btn btn-success btn-sm"
                    v-on:click="show_editor('user')">
                <i class="fa fa-user-plus"></i>
            </button>
            <div id="admin_editor_user" class="modal fade text-left" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">CREA NUOVO UTENTE</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="userName">USERNAME</label>
                                    <input type="text" name="username" placeholder="username" class="form-control" id="userName" aria-describedby="userNameHelp">
                                    <small id="userNameHelp" class="form-text text-muted">Lo username del nuovo utente da aggiungere.</small>
                                </div>
                                <div class="form-group">
                                    <label for="userPassword">PASSWORD</label>
                                    <input type="password" name="password" placeholder="password" class="form-control" id="userPassword" aria-describedby="userPasswordHelp">
                                    <small id="userPasswordHelp" class="form-text text-muted">La password per il nuovo utente da aggiungere.</small>
                                </div>
                                <div class="form-group">
                                    <label for="userRoles">RUOLO</label>
                                    <select class="form-control form-control-lg" name="role" id="userRoles" aria-describedby="userRolesHelp">
                                        <option :value="elm.id" v-for="elm in roles">{{ elm.role }}</option>
                                    </select>
                                    <small id="userRolesHelp" class="form-text text-muted">Il ruolo associato al nuovo utente da aggiungere.</small>
                                </div>
                            </form>
                            <div class="alert alert-danger" role="alert" v-if="error">
                                Si &egrave; verificato un errore, riprovare pi&ugrave; tardi.
                                <hr><span class="text-monospace">{{ error }}</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-on:click="create_new()" type="button" class="btn btn-primary">SALVA</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CHIUDI</button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success btn-sm"
                    v-on:click="show_editor('role')">
                <i class="fa fa-id-badge"></i>
            </button>
            <div id="admin_editor_role" class="modal fade text-left" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">CREA NUOVO RUOLO</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="roleTitle">RUOLO</label>
                                    <input type="text" name="role" placeholder="role" class="form-control" id="roleTitle" aria-describedby="roleTitleHelp">
                                    <small id="roleTitleHelp" class="form-text text-muted">Il nome del nuovo ruolo da aggiungere.</small>
                                </div>
                            </form>
                            <div class="alert alert-danger" role="alert" v-if="error">
                                Si &egrave; verificato un errore, riprovare pi&ugrave; tardi.
                                <hr><span class="text-monospace">{{ error }}</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-on:click="create_new()" type="button" class="btn btn-primary">SALVA</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CHIUDI</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="alert alert-success mt-3 text-left" role="alert" v-if="show_success_message">
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
    <?php endif; ?>
</div>