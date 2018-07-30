<div class="container">
<?php
    $url_base = base_url() . 'index.php/student/calendar/day/';

    $day_date = new DateTime($DAY['DayDate']);
    $day_str = $day_date->format('Y-m-d');
?>
<div class="card">
    <div class="card-content">
        <h3>Día <?= $day_date->format('d-m-Y') ?></h3>

        <h4>Horas disponibles</h4>

        <div class="mt-1">Click en una hora para anotarte o cambiar de hora.</div>

        <div class="mb-1">La hora en <span class="green-text">verde</span> es en la que estás anotado.</div>

        <div>
            <?php
                echo form_open($url_base . $day_str);

                $is_user_in_this_day = FALSE;

                ?><div class="row"><?php

                foreach ($HOURS as $hour) :
                    $style = 'btn';

                    if ($hour['IdUser'] != NULL)
                    {
                        if ($hour['IdUser'] == $ID_USER) {
                            $style .= ' green';
                            $is_user_in_this_day = TRUE;
                        } else {
                            $style .= ' disabled';
                        }
                    }

                    ?><div class="col s1">
                    <button class="<?= $style ?>" type="submit" name="id-hour" value="<?=$hour['IdHour']?>"><?=
                        $hour['HourString']
                    ?></button></div><?php

                endforeach; ?></div><?php

                if ($is_user_in_this_day): ?>
                    <button class="btn red" type="submit" name="remove-me" value="me">Bórrame</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>