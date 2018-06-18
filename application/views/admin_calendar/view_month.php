<div class="container">
    <table class="centered">

    <thead>
        <tr>
            <th>L</th><th>M</th><th>X</th><th>J</th>
            <th>V</th><th>S</th><th>D</th>
        </tr>
    </thead>

    <tbody>
    <?php
        $table_body_html = '';
        $number_days = count($month);
        $starting_day = $month[0];

        
        // First week filler.
        $i = 0;
        
        $start_week_day = (new DateTime($starting_day['DayDate']))->format('N') - 1;

        $table_body_html .= '<tr>';

        while ($i < $start_week_day) :
            $table_body_html .= '<td></td>';
            $i++;
        endwhile;

        // Month renderer.

        $i = 0;

        while($i < $number_days) :
            $day = $month[$i];
            $day_date = new DateTime($day['DayDate']);

            $day_index = $day_date->format('N');

            $table_body_html .= '<td>' . $day_date->format('d') . '</td>';

            if ($day_index == 7) :
                $table_body_html .= '</tr><tr>';
            endif;

            $i++;
        endwhile;

        echo $table_body_html;
    ?>
    </tbody>
    </table>
</div>