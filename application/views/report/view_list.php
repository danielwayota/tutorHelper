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
            
            $months = [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];
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
                        data-target="delete-modal"
                        data-date="<?= $view_str ?>"
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

<!-- Modal Structure -->
<div id="delete-modal" class="modal">
    <div class="modal-content">
        <h4>Borrar <span id="date-to-delete-label"></span></h4>
        <p class="red-text text-darken-1"><i> Se borrará el registro definitivamente.</i></p>
    </div>
    <div class="modal-footer">
        <?php echo form_open(base_url() . 'index.php/report/delete/') ?>
            <input id="date-to-delete" name="date-to-delete" type="hidden">
            <button type="button" class="modal-close btn green"><i class="material-icons">cancel</i></button>
            <button type="submit" class="btn red"><i class="material-icons">delete</i></button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, {});

    const datehiddenInput = document.getElementById('date-to-delete');
    const titleLabel = document.getElementById('date-to-delete-label');

    function deleteBtn(event) {
        console.log(event.target);
        const btn = event.target;

        const date = btn.getAttribute('data-date');

        datehiddenInput.value = date;
        titleLabel.innerHTML = date;
    }

    const buttons = document.querySelectorAll('.btn.red.modal-trigger');
    buttons.forEach((e) => e.addEventListener('click', deleteBtn))
});
</script>