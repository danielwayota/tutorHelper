<div class="container">
<div class="card">
    <div class="card-content">
        <h3>Informes</h3>

        <!-- Do some shit -->
        <table class="striped">
        <thead>
        <tr>
            <th>Mes</th>
            <th>Año</th>
            <th>Acciones</th>
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
                    ?>">Ver</a>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
        </table>
    </div>
</div>
</div>