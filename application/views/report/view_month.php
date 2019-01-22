<?php
    $url_base = base_url() . 'index.php/report';
?>

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

        <h5 class="mb-2">Informe de <?= $month_name ?> - <?= $year ?></h5>

        <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Horas</th>
                <th>Precio</th>
                <th>Total</th>
                <th>Pagado</th>
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
                <td class="truncate"><?= $report['Name'] ?></td>
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
                <td>
                <?php echo form_open($url_base . '/payment' . '/' . $month . '-' . $year)  ?>
                    <?php if ($report['Paid']) : ?>
                        <button class="btn green" type="submit" name="id-user" value="<?= $report['IdUser'] ?>">
                            <i class="material-icons">attach_money</i>
                        </button>
                    <?php else : ?>
                        <button class="btn orange" type="submit" name="id-user" value="<?= $report['IdUser'] ?>">
                            <i class="material-icons">money_off</i>
                        </button>
                    <?php endif; ?>
                </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
        <div class="input-field col s12 mt-3">
            <a class="btn grey" href="<?php echo $url_base ?>">
                <i class="material-icons">keyboard_backspace</i>
            </a>
        </div>
    </div>
</div>