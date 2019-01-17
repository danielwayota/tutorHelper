<div class="container">

<?php
    $url_base = base_url() . 'index.php/profile';
?>

<div class="card">
    <div class="card-content">
        <h4 class="mb-2">Editar perfil:</h4>

        <?php echo form_open($url_base . '/update'); ?>
        <div class="row">
            <div class="input-field col s12">
                <input type="text" name="email" id="email" value="<?= $user['Email'] ?>" required />
                <label for="email">Email</label>
                <?php
                    $validation_error = form_error('email');
                    if ($validation_error) : ?>
                        <span class="helper-text red-text" data-error="wrong" data-success="right">
                            <?= $validation_error?>
                        </span>
                <?php endif; ?>
            </div>

            <div class="input-field col s12">
                <input type="text" name="name" id="name" value="<?= $user['Name'] ?>" required />
                <label for="name">Nombre</label>
                <?php
                    $validation_error = form_error('name');
                    if ($validation_error) : ?>
                        <span class="helper-text red-text" data-error="wrong" data-success="right">
                            <?= $validation_error?>
                        </span>
                <?php endif; ?>
            </div>

            <div class="input-field col s12 m6">
                <input type="password" name="password" id="password" />
                <label for="password">Contraseña</label>
                <?php
                    $validation_error = form_error('password');
                    if ($validation_error) : ?>
                        <span class="helper-text red-text" data-error="wrong" data-success="right">
                            <?= $validation_error?>
                        </span>
                <?php endif; ?>
            </div>

            <div class="input-field col s12 m6">
                <input type="password" name="password2" id="password2" />
                <label for="password2">Repetir contraseña</label>
                <?php
                    $validation_error = form_error('password2');
                    if ($validation_error) : ?>
                        <span class="helper-text red-text" data-error="wrong" data-success="right">
                            <?= $validation_error?>
                        </span>
                <?php endif; ?>
            </div>

            <div class="input-field col s12 mt-3">
                <button class="btn green" type="submit"><i class="material-icons">check</i></button>
            </div>
        </div>
        </form>
    </div>
</div>

</div>