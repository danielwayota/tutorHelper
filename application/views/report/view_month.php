<div class="container">
<div class="card">
    <div class="card-content">
        <?php
            $months = [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];
            
            $month = $DATE_DATA[0];
            $year = $DATE_DATA[1];
            
            $month_name = $months[$month - 1];
        ?>

        <h4>Informe de <?= $month_name ?> - <?= $year ?></h4>

        <table>
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Horas</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($MONTH_REPORT as $report) :
            $hours = $report['Hours'] ? $report['Hours'] : 0;
            $custom_price = FALSE;
            $price = $CONFIG['BasePrice'];
            if ($report['PriceOverride'] != 0) {
                $price = $report['PriceOverride'];
                $custom_price = TRUE;
            }

            ?>
            <tr>
                <td><?= $report['Name'] ?></td>
                <td><?= $hours ?></td>
                <td class="<?= $custom_price ? 'yellow lighten-4' : '' ?>">
                    <?= number_format($price, 2); ?>€
                </td>
                <?php
                    if ($report['PriceOverride'] != 0) {
                        $precio_total = $hours * $report['PriceOverride']; 
                    } else {
                        $precio_total = $hours * $CONFIG['BasePrice']; 
                    }
                ?>
                <td><?= number_format($precio_total, 2)?>€</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
    </div>
</div>