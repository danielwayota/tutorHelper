<div class="container">
<?php
    $url_base = base_url() . 'index.php/student/calendar/day/';

    $day_date = new DateTime($DAY['DayDate']);
    $day_str = $day_date->format('Y-m-d');
?>
<div class="card">
    <div class="card-content">
        <h4>Fecha: <?= $day_date->format('d-m-Y') ?></h4>

        <h6 class="mt-3 mb-2">Escoger hora:</h6>

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

                    ?><div class="col">
                    <button class="mb-2 <?= $style ?>" type="submit" name="id-hour" value="<?=$hour['IdHour']?>"><?=
                        $hour['HourString']
                    ?></button></div><?php

                endforeach; ?></div><?php

                if ($is_user_in_this_day): ?>
                <button class="mt-3 btn red" type="submit" name="remove-me" value="me"><i class="material-icons">delete</i></button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>