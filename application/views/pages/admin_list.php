<div class="container">

<?php
    $url_base = base_url() . 'index.php/pages';
?>
<div class="card">
    <div class="card-content">
        <h3>Administrador de páginas</h3>

        <a class="btn blue" href="<?= $url_base ?>/create">
            <i class="material-icons left">add</i>Crear
        </a>

        <h5>Lista de páginas<h5>

        <table>
        <thead class="grey lighten-4">
            <tr>
                <th>Título</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pages as $page) : ?>
                <tr>
                    <td><?= $page['Title'] ?></td>
                    <td>
                        <a
                            class="btn green"
                            href="<?= $url_base ?>/edit/<?= $page['IdPage'] ?>"
                        >
                            Editar
                        </a>

                        <button
                            data-target="modal<?= $page['IdPage'] ?>"
                            class="btn red modal-trigger"
                            type="submit">
                            Borrar
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        </table>

    </div>

    <!-- Modals Setup -->
    <?php foreach ($pages as $page) : ?>

    <div id="modal<?= $page['IdPage'] ?>" class="modal">
        <div class="modal-content">
            <h4>Borrar: <?= $page['Title'] ?></h4>
            <p>Se borrará esta página y no se podrá recuperar.</p>
        </div>
        <div class="modal-footer">
            <?php echo form_open($url_base.'/delete/'. $page['IdPage'] ); ?>
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