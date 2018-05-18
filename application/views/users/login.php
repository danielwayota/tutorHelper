<div class="row valign-wrapper" style="height: 80vh;">
    <div class="card col s12 m6 offset-m3 l4 offset-l4">
        <?php echo form_open(base_url() . 'index.php/users/login') ?>
            <div class="card-content row" style="margin-bottom: 0;">

                <div class="input-field col s12">
                    <i class="material-icons prefix">email</i>
                    <input id="email" type="text" name="email" />
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
                    <i class="material-icons prefix">vpn_key</i>
                    <input id="password" type="password" name="password" />
                    <label for="password">Contraseña</label>

                    <?php
                    $validation_error = form_error('password');
                    if ($validation_error) : ?>
                        <span class="helper-text red-text" data-error="wrong" data-success="right">
                            <?= $validation_error?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="input-field col">
                    <button class="btn" type="submit">Acceder</button>
                </div>

            </div>
        </form>
    </div>
</div>
