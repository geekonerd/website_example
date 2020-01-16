<nav class="navbar navbar-expand-md navbar-dark bg-dark rounded mb-4">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item<?php echo "index.php" === $PAGE ? ' active' : '' ?>">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item<?php echo "categories.php" === $PAGE ? ' active' : '' ?>">
            <a class="nav-link" href="categories.php">Categorie</a>
        </li>
        <li class="nav-item<?php echo "contacts.php" === $PAGE ? ' active' : '' ?>">
            <a class="nav-link" href="contacts.php">Contatti</a>
        </li>
    </ul>
    <div id="loading" class="spinner-border ml-auto text-secondary"
         role="status" aria-hidden="true" v-if="show_loading">
    </div>
</nav>