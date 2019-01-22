<?php
$months = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];
?>

<div class="container">
<div class="card">
    <div class="card-content">
        <h4 class="mb-2">Mis informes:</h4>

        <!-- Do some shit -->
        <table class="striped">
        <thead>
        <tr>
            <th>Mes</th>
            <th>Año</th>
            <th>Acciones:</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($MONTH_LIST as $date):?>
        <?php
            $date_obj = new DateTime($date['DayDate']);
            
            $month = $date_obj->format('m');
            $month_name = $months[$month - 1];
            $year = $date_obj->format('Y');

            $view_str = $month . '-' . $year;
            ?>

            <tr>
                <td><?= $month_name ?></td>
                <td><?= $year ?></td>
                <td>
                    <a class="btn green" href="<?=
                        base_url() . 'index.php/report/month/'. $view_str
                    ?>">
                        <i class="material-icons">visibility</i>
                    </a>

                    <button
                        data-target="delete-modal-<?= $view_str ?>"
                        class="btn red modal-trigger"
                    >
                    <i class="material-icons">delete</i>
                    </button>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
        </table>
    </div>
</div>
</div>

<?php foreach($MONTH_LIST as $date):?>

<?php
    $date_obj = new DateTime($date['DayDate']);

    $month = $date_obj->format('m');
    $month_name = $months[$month - 1];
    $year = $date_obj->format('Y');

    $view_str = $month . '-' . $year;
?>

<!-- Modal Structure -->
<div id="delete-modal-<?= $view_str ?>" class="modal">
    <div class="modal-content">
        <h5>Borrar el informe: <strong><?= $month_name ?> - <?= $year ?></strong></h5>
        <p class="red-text text-darken-1"><i> Esta acción borrará todos los datos asociados a este mes.</i></p>
    </div>
    <div class="modal-footer">
        <?php echo form_open(base_url() . 'index.php/report/delete/') ?>
            <input id="date-to-delete" name="date-to-delete" type="hidden" value="<?= $view_str ?>">
            <button type="button" class="modal-close btn green"><i class="material-icons">cancel</i></button>
            <button type="submit" class="btn red"><i class="material-icons">delete</i></button>
        </form>
    </div>
</div>
<?php endforeach; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, {});
});
</script>