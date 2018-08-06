<div class="container">
<div class="card">
    <div class="card-content">
        <h3>Informe</h3>

        <!-- Do some shit -->
        <?php foreach($MONTH_LIST as $date):?>

        <?php
            $date_obj = new DateTime($date['DayDate']);

            $months = [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];
            $month_str = $months[$date_obj->format('m') - 1]
        ?>

            <p><?= $month_str ?></p>

        <?php endforeach; ?>
    </div>
</div>
</div>