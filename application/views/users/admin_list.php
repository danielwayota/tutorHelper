<div class="container">

<?php
    $url_base = base_url() . 'index.php/users';
?>

<div class="card">
    <div class="card-content">
        <h3>Administrador de usuarios</h3>

        <a class="btn blue" href="<?= $url_base ?>/create">
            <i class="material-icons left">add</i>Crear
        </a>

        <h5>Lista de usuarios</h5>

        <table>
            <thead>
                <tr>
                    <th>Email</th><th>Nombre</th><th>Estado</th><th>Acciones</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user['Email'] ?></td>
                    <td><?= $user['Name'] ?></td>
                    <td>
                        <?php if ($user['Enabled']) : ?>
                            <span class="green-text">Activado</span>
                        <?php else : ?>
                            <span class="grey-text">Desactivado</span>
                        <?php endif; ?></td>
                    <td>
                        <a
                            class="btn green"
                            href="<?= $url_base ?>/edit/<?= $user['IdUser'] ?>">
                            Editar
                        </a>

                        <button
                            data-target="modal<?= $user['IdUser'] ?>"
                            class="btn red modal-trigger">
                            Borrar
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
            <h4>Borrar: <?= $user['Email'] ?></h4>
            <p>Se borrará este usuario y no se podrá recuperar.</p>
        </div>
        <div class="modal-footer">
            <?php echo form_open($url_base.'/delete/'. $user['IdUser'] ); ?>
                <button type="reset" class="modal-close btn green">Cancelar</button>
                <button type="submit" class="modal-close btn red">Borrar</button>
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