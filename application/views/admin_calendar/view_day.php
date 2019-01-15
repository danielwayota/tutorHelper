<div class="container">
<?php
    $url_base = base_url() . 'index.php/admin/calendar/day/';

    $day_date = new DateTime($DAY['DayDate']);
    $day_str = $day_date->format('Y-m-d');
    ?>
<div class="card">
    <div class="card-content">
        <h3>Día <?= $day_date->format('d-m-Y') ?></h3>


        <?php echo form_open($url_base . $day_str) ?>
        <div class="row">
            <h4>Lista de alumnos del día</h4>

            <table class="responsive-table">
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Alumno</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <?php foreach($SCHEDULE as $hour) : ?>
            <tr>
                <td><?= $hour['HourString'] ?></td>
                <td>
                    <?php if ($hour['IdUser']) : ?>
                        <strong><?= $hour['Name'] ?></strong>
                    <?php else : ?>...<?php endif; ?>
                </td>
                <td>
                    <button
                        type="submit"
                        name="remove-student"
                        value="<?= $hour['IdUser'] ?>"
                        class="btn orange">Quitar Alumno</button>
                    <button
                        type="submit"
                        name="remove-hour"
                        value="<?= $hour['IdHour'] ?>"
                        class="btn red">Quitar Hora</button>
                </td>
            </tr>
            <?php endforeach; ?>
            </table>
        </div>

        <div class="row">
            <h5>Cambiar horario</h5>
            <p class="red-text">*Esta acción borrará a todos los alumnos para poder crear el nuevo horario.</p>

            
            <div class="input-field col s12 m6">
                <select name="schedule">
                    <?php foreach ($CONFIG_SCHEDULES as $schedule): ?>
                        <option value="<?= $schedule['IdConfigSchedule'] ?>"><?=
                            $schedule['Name']
                        ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-field col s12 m6">
                <button type="submit" name="reset-schedule" value="true" class="btn green">Resetear</button>
            </div>

        </div>

        <div class="row">
            <p><strong>Bloqueado</strong></p>
            
            <div class="input-field col s12 m4 l2">
                <div class="switch">
                    <label>
                        No<input type="checkbox" name="locked" <?php
                            if ($DAY['Locked']) {echo "checked";}
                        ?>>
                        <span class="lever"></span>
                        Sí
                    </label>
                </div>
            </div>

            <div class="input-field col s12">
                <button class="btn green" type="submit" name="edit-day" value="true">Guardar</button>
            </div>
        </div>
        </form>

    </div>
</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, {});
});
</script>