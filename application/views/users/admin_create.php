<div class="container">

<?php
    $url_base = base_url() . 'index.php/users';
?>

<div class="card">
    <div class="card-content">
        <h3>Crear Ususario</h3>

        <?php echo form_open($url_base . '/create') ?>
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
                <input type="password" name="password" id="password" required />
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
                <input type="password" name="password2" id="password2" required />
                <label for="password2">Repetir Contraseña</label>
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

            <p><strong>Tiene Precio Personalizado?</strong></p>

            <div class="input-field col s12 m4 l2">
                <div class="switch">
                    <label>
                    No<input type="checkbox" name="use-custom-price">
                    <span class="lever"></span>
                    Sí
                    </label>
                </div>
            </div>

            <div class="input-field col s12 m8 l10">
                <input type="number" step=".01" name="custom-price" id="custom-price" />
                <label for="custom-price">Precio Personalizado</label>
            </div>

            <div class="input-field col s12">
                <button class="btn green" type="submit">Guardar</button>
            </div>
        </div>
        </form>
    </div>
</div>

</div>