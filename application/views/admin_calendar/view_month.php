<div class="container">

    <div class="card">
        <div class="card-content">
            <h3>Calendario Profesor</h3>

            <table class="centered calendar">

            <thead>
                <tr>
                    <th>L</th><th>M</th><th>X</th><th>J</th>
                    <th>V</th><th>S</th><th>D</th>
                </tr>
            </thead>

            <tbody>
            <?php
                $number_days = count($month);
                $starting_day = $month[0];

                
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
                    $day = $month[$i];
                    $day_date = new DateTime($day['DayDate']);
                    $today = new DateTime();

                    $day_index = $day_date->format('N');

                    $day_number = $day_date->format('d');
                    $day_url = base_url() . 'index.php/admin/calendar/day/' . $day_number;

                    $day_color = '';

                    // Select the day's color.
                    // - Locked: Red
                    // - Past day: green
                    // - Today: Blue BG
                    if ($day['Locked']) :
                        $day_color = 'red-text';
                    else:
                        if ($day_number < $today->format('d')):
                            $day_color = 'grey-text';
                        endif;
                    endif;

                    if ($day_number == $today->format('d')):
                        $day_color .= ' blue lighten-4';
                    endif;

                    // Day 'button'
                    ?><td><?php
                        ?><a class="<?= $day_color ?>" href="<?= $day_url ?>"><?=
                            $day_number
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
    </div>
</div>