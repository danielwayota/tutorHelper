<div class="container">

<?php
    $url_base = base_url() . 'index.php/users';
?>

<div class="card">
    <div class="card-content">
        <h4 class="mb-2">Administrador de usuarios:</h4>

        <div class="mb-3">
        <a class="btn blue" href="<?= $url_base ?>/create">
            <i class="material-icons left">add</i>Crear
        </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="hide-on-med-and-down">Email</th><th>Nombre</th><th></th><th>Acciones:</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td class="hide-on-med-and-down"><div class="truncate"><?= $user['Email'] ?></div></td>
                    <td><div class="truncate"><?= $user['Name'] ?></div></td>
                    <td>
                        <?php if ($user['Enabled']) : ?>
                            <span class="green-text">
                                <i class="material-icons">done</i>
                            </span>
                        <?php else : ?>
                            <span class="grey-text">
                                <i class="material-icons">block</i>
                            </span>
                        <?php endif; ?></td>
                    <td>
                        <a
                            class="btn green"
                            href="<?= $url_base ?>/edit/<?= $user['IdUser'] ?>">
                            <i class="material-icons">create</i>
                        </a>

                        <button
                            data-target="modal<?= $user['IdUser'] ?>"
                            class="btn red modal-trigger">
                            <i class="material-icons">delete</i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modals Setup -->
    <?php foreach ($users as $user) : ?>

    <div id="modal<?= $user['IdUser'] ?>" class="modal">
        <div class="modal-content">
            <h5 class="mb-2">Eliminar: <?= $user['Email'] ?></h5>
            <p class="red-text text-darken-1"><i> Se borrará este usuario definitivamente.</i></p>
        </div>
        <div class="modal-footer">
            <?php echo form_open($url_base.'/delete/'. $user['IdUser'] ); ?>
                <button type="reset" class="modal-close btn green"><i class="material-icons">cancel</i></button>
                <button type="submit" class="modal-close btn red"><i class="material-icons">delete</i></button>
            </form>
        </div>
    </div>

    <?php endforeach; ?>
</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, {});
});
</script>