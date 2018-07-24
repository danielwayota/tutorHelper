<div class="container">
<?php
    $url_base = base_url() . 'index.php/student/calendar/day/';

    $day_date = new DateTime($day['DayDate']);
    $day_number = $day_date->format('d');
?>
<div class="card">
    <div class="card-content">
        <h3>Día <?= $day_date->format('d-m-Y') ?></h3>

        <h4>Horas disponibles</h4>

        <div class="row">
            <?php
                echo form_open($url_base . $day_number);
                foreach ($hours as $hour)
                {
                    $style = 'btn';

                    if ($hour['IdUser'] != NULL)
                    {
                        $style .= ' disabled';
                    }

                    ?><div class="col s1">
                    <button class="<?= $style ?>" type="submit" name="id-hour" value="<?=$hour['IdHour']?>"><?=
                        $hour['HourString']
                    ?></button></div><?php
                }
            ?></form>
        </div>
    </div>
</div>