<div class="container">
    <div class="row">

    <?php
        $number_days = count($month);
        $starting_day = $month[0];

        // First week filler.
        $i = 0;

        $start_week_day = (new DateTime($starting_day['DayDate']))->format('N') - 1;

        while ($i < $start_week_day) :
            ?><div class="col s2"></div><?php
            $i++;
        endwhile;

        // Month renderer.

        $i = 0;

        while($i < $number_days) :
            $day = $month[$i];
            $day_date = new DateTime($day['DayDate']);

            $day_index = $day_date->format('N');

            if ($day_index < 6) :
                ?><div class="col s2"><?= $day_date->format('d'); ?></div><?php

                $i++;
            else :
                ?><div class="col s1"><?=
                    $day_date->format('d');
                ?></div><?php
                    if ($i + 1 < $number_days) :
                        $sunday = $month[$i + 1];
                        ?><div class="col s1"><?=
                            date('d', strtotime($sunday['DayDate']));
                        ?></div><?php
                    endif;

                $i += 2;
            endif;
        endwhile;
    ?>
    </div>
</div>