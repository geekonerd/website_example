<div class="p-3 bg-dark rounded">
    <?php if (!$USER) : ?>
        <h6 class="text-white">Autenticati</h6>
        <form method="POST" class="mb-1">
            <div class="input-group input-group-sm mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa fa-user"></i></span>
                </div>
                <input type="text" name="username" class="form-control"
                       placeholder="username" aria-label="Username"
                       aria-describedby="basic-addon1">
            </div>
            <div class="input-group input-group-sm mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon2">
                        <i class="fa fa-lock"></i></span>
                </div>
                <input type="password" name="password" class="form-control"
                       placeholder="password" aria-label="Password"
                       aria-describedby="basic-addon2">
            </div>
            <div class="input-group-append mb-0">
                <button class="btn btn-success btn-sm" type="submit">ENTRA</button>
                <div class="input-group-append">
                    <div class="input-group-text bg-transparent text-white border-0">
                        <input id="remember" name="remember" type="checkbox"
                               aria-label="Mantieni collegato">
                        <label class="form-check-label" for="remember">&nbsp;Ricorda</label>
                    </div>
                </div>
            </div>
        </form>

    <?php else : ?>
        <form method="POST" class="mb-0">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa fa-user-circle"></i></span>
                </div>
                <input class="form-control" type="text" readonly
                       placeholder="<?php echo $USER->username; ?> (<?php echo $USER->role; ?>)">
                <div class="input-group-append">
                    <input type="hidden" name="logout">
                    <button class="btn btn-danger btn-sm" type="submit">ESCI</button>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>