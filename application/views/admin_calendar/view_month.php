<div class="container">

    <div class="card">
        <div class="card-content">
            <h4 class="mb-3">Gestión de mes:</h4>
            <?php
            function renderMonth($month_to_render) {
                $months = [
                    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ];
                $month_str = $months[(new DateTime($month_to_render[0]['DayDate']))->format('m') - 1];
                
                ?>
                <div class="mb-3">
                <h5><?= $month_str ?></h5>

                <table class="centered calendar">

                <thead>
                    <tr>
                        <th>L</th><th>M</th><th>X</th><th>J</th>
                        <th>V</th><th>S</th><th>D</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                    $number_days = count($month_to_render);
                    $starting_day = $month_to_render[0];

                    
                    // First week filler.
                    $i = 0;
                    
                    $start_week_day = (new DateTime($starting_day['DayDate']))->format('N') - 1;

                    ?><tr><?php

                    while ($i < $start_week_day) :
                        ?><td></td><?php
                        $i++;
                    endwhile;

                    // Month renderer.

                    $i = 0;

                    while($i < $number_days) :
                        $day = $month_to_render[$i];
                        $day_date = new DateTime($day['DayDate']);
                        $today = new DateTime();

                        $day_index = $day_date->format('N');

                        $day_number = $day_date->format('d');
                        $day_month = $day_date->format('m');

                        $day_str = $day_date->format('Y-m-d');
                        $day_url = base_url() . 'index.php/admin/calendar/day/' . $day_str;

                        $day_color = '';

                        // Select the day's color.
                        // - Locked: Red
                        // - Past day: green
                        // - Today: Blue BG

                        $modified = FALSE;

                        if ($day['Locked']) :
                            $day_color = 'red-text';
                            $modified = TRUE;
                        else:
                            if ($day_month < $today->format('m')):
                                $day_color = 'grey-text';
                                $modified = TRUE;
                            elseif ($day_month == $today->format('m')):
                                if ($day_number <= $today->format('d')):
                                    $day_color = 'grey-text';
                                    $modified = TRUE;
                                endif;
                            endif;
                        endif;    

                        if (!$modified && $day['Full']):
                            $day_color = 'orange-text';
                        endif;

                        if (
                            ($day_number == $today->format('d'))
                            &&
                            ($day_month == $today->format('m'))
                            ):
                            $day_color .= ' blue lighten-4';
                        endif;

                        // Day 'button'
                        ?><td><?php
                            ?><a class="<?= $day_color ?>" href="<?= $day_url ?>"><?=
                                $day_number
                            ?><?php
                                if ($day['People']): ?>
                                    <sup><?= $day['People']?></sup>
                                <?php endif;
                            ?></a><?php
                        ?></td><?php

                        if ($day_index == 7) :
                            ?></tr><tr><?php
                        endif;

                        $i++;
                    endwhile;
                ?>
                </tbody>
                </table>
                </div>
            <?php } ?>

            <?php
                renderMonth($MONTH);
                renderMonth($NEXT_MONTH);
            ?>
        </div>
    </div>
</div>

<style>
td {
    position: relative;
}
sup {
    position: absolute;
    top: 12px;
    right: 12px;
}
</style>