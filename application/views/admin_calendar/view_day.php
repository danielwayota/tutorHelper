<div class="container">
<?php
    $url_base = base_url() . 'index.php/admin/calendar';

    $day_date = new DateTime($DAY['DayDate']);
    $day_str = $day_date->format('Y-m-d');
    ?>
<div class="card">
    <div class="card-content">
        <h4 class="mb-2">Fecha: <?= $day_date->format('d-m-Y') ?></h4>


        <?php echo form_open($url_base . '/day' . '/' . $day_str) ?>
        <div class="row">
            <h5 class="mb-2">Usuarios inscritos:</h5>

            <table>
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Usuario</th>
                    <th>Acciones:</th>
                </tr>
            </thead>
            <?php foreach($SCHEDULE as $hour) : ?>
            <tr>
                <td><?= $hour['HourString'] ?></td>
                <td class="truncate">
                    <?php if ($hour['IdUser']) : ?>
                        <strong><?= $hour['Name'] ?></strong>
                    <?php else : ?>...<?php endif; ?>
                </td>
                <td>
                    <button
                        type="submit"
                        name="remove-student"
                        value="<?= $hour['IdUser'] ?>"
                        class="btn orange"><i class="material-icons">person_add_disabled</i></button>
                    <button
                        type="submit"
                        name="remove-hour"
                        value="<?= $hour['IdHour'] ?>"
                        class="btn red"><i class="material-icons">delete</i></button>
                </td>
            </tr>
            <?php endforeach; ?>
            </table>
        </div>

        <div class="row">
            <h5 class="mt-3">Cambiar horario:</h5>
            <p class="red-text text-darken-1"><i>Esta acción borrará a todos los usuarios ya registrados para poder crear el nuevo horario.</i></p>

            <div class="mt-2">
                <div class="input-field col s9 m6">
                    <select name="schedule">
                        <?php foreach ($CONFIG_SCHEDULES as $schedule): ?>
                            <option value="<?= $schedule['IdConfigSchedule'] ?>"><?=
                                $schedule['Name']
                            ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="input-field col s2 m6">
                    <button type="submit" name="reset-schedule" value="true" class="btn green">
                        <i class="material-icons">loop</i>
                    </button>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <p><strong>Bloquear día:</strong></p>
            
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

            <div class="input-field col s12 mt-3">
                <a class="btn grey" href="<?php echo $url_base . '/month' ?>">
                    <i class="material-icons">keyboard_backspace</i>
                </a>
                <button class="btn green" type="submit" name="edit-day" value="true">
                    <i class="material-icons">check</i>
                </button>
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