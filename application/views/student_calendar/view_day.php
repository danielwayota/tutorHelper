<div class="container">
<?php
    $url_base = base_url() . 'index.php/admin/calendar/day/';

    $day_date = new DateTime($day['DayDate']);
    $day_number = $day_date->format('d');
?>
<div class="card">
    <div class="card-content">
        <h3>Día <?= $day_date->format('d-m-Y') ?></h3>
    </div>
</div>