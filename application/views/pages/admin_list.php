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
            <?php foreach ($PAGES as $PAGE) : ?>
                <tr>
                    <td><?= $PAGE['Title'] ?></td>
                    <td>
                        <a
                            class="btn green"
                            href="<?= $url_base ?>/edit/<?= $PAGE['IdPage'] ?>"
                        >
                            Editar
                        </a>

                        <button
                            data-target="modal<?= $PAGE['IdPage'] ?>"
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
    <?php foreach ($PAGES as $PAGE) : ?>

    <div id="modal<?= $PAGE['IdPage'] ?>" class="modal">
        <div class="modal-content">
            <h4>Borrar: <?= $PAGE['Title'] ?></h4>
            <p>Se borrará esta página y no se podrá recuperar.</p>
        </div>
        <div class="modal-footer">
            <?php echo form_open($url_base.'/delete/'. $PAGE['IdPage'] ); ?>
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