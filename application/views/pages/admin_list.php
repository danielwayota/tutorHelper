<div class="container">

<?php
    $url_base = base_url() . 'index.php/pages';
?>
<div class="card">
    <div class="card-content">
        <h4 class="mb-2">Mis contenidos:</h4>

        <div class="mb-3">
            <a class="btn blue" href="<?= $url_base ?>/create">
                <i class="material-icons left">add</i>Crear
            </a>
        </div>


        <table>
        
        <tbody>
            <?php foreach ($PAGES as $PAGE) : ?>
                <tr>
                    <td class="truncate"><?= $PAGE['Title'] ?></td>
                    <td>
                        <a
                            class="btn green"
                            href="<?= $url_base ?>/edit/<?= $PAGE['IdPage'] ?>"
                        >
                        <i class="material-icons">create</i>
                        </a>

                        <button
                            data-target="modal<?= $PAGE['IdPage'] ?>"
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
    <?php foreach ($PAGES as $PAGE) : ?>

    <div id="modal<?= $PAGE['IdPage'] ?>" class="modal">
        <div class="modal-content">
            <h5 class="mb-1">Eliminar: <?= $PAGE['Title'] ?></h5>
            <p>¿ Procede a eliminar el contenido <span class="red-text text-darken-1">definitivamente</span> ?</p>
        </div>
        <div class="modal-footer">
            <?php echo form_open($url_base.'/delete/'. $PAGE['IdPage'] ); ?>
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