<div class="container">

<?php
    $url_base = base_url() . 'index.php/users';
?>

<div class="card">
    <div class="card-content">
        <h4 class="mb-2">Editar usuario:</h4>

        <?php echo form_open($url_base . '/edit' . '/' . $user['IdUser']) ?>
        <div class="row">
            <div class="input-field col s12">
                <div class="switch">
                    <label>
                    Desactivado<input type="checkbox" name="enabled" <?php
                        if ($user['Enabled']) { echo "checked"; }
                    ?>>
                    <span class="lever"></span>
                    Activado
                    </label>
                </div>
            </div>

            <div class="input-field col s12 mt-3">
                <input type="text" id="email" disabled value="<?= $user['Email'] ?>"  />
                <label for="email">Email</label>
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

            <div class="input-field col s12">
                <input type="text" name="comments" value="<?= $user['Comments'] ?>" id="comments" />
                <label for="comments">Comentarios</label>
            </div>

            <div class="input-field col s12 mt-3">
                <strong>¿Precio personalizado?</strong>
            </div>

            <div class="input-field col s12 m4 l2">
                <div class="switch">
                    <label>
                    No<input type="checkbox" name="use-custom-price" <?php
                        if ($user['PriceOverride']) {echo "checked";}
                    ?>>
                    <span class="lever"></span>
                    Sí
                    </label>
                </div>
            </div>

            <div class="input-field col s12 m8 l10">
                <input type="number" step=".01" value="<?= $user['PriceOverride'] ?>" name="custom-price" id="custom-price" />
                <label for="custom-price">Precio personalizado</label>
            </div>

            <div class="input-field col s12 mt-3">
                <a class="btn grey" href="<?php echo $url_base . '/list' ?>"><i class="material-icons">keyboard_backspace</i></a>
                <button class="btn green" type="submit"><i class="material-icons">check</i></button>
            </div>
        </div>
        </form>
    </div>
</div>

</div>