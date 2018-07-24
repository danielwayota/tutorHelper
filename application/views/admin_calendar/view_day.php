<div class="container">
<?php
    $url_base = base_url() . 'index.php/admin/calendar/day/';

    $day_date = new DateTime($day['DayDate']);
    $day_number = $day_date->format('d');
?>
<div class="card">
    <div class="card-content">
        <h3>Día <?= $day_date->format('d-m-Y') ?></h3>

        <div class="row">
        <?php echo form_open($url_base . $day_number) ?>
            
            <p><strong>Límite personalizado</strong></p>
            
            <div class="input-field col s12 m4 l2">
                <div class="switch">
                    <label>
                        No<input type="checkbox" name="use-max-people-override" <?php
                            if ($day['MaxPeopleOverride']) {echo "checked";}
                        ?>>
                        <span class="lever"></span>
                        Sí
                    </label>
                </div>
            </div>
            
            <div class="input-field col s12 m8 l10">
                <input type="number" min="0" value="<?= $day['MaxPeopleOverride'] ?>" name="max-people-override" id="max-people-override" />
                <label for="max-people-override">Límite de gente</label>
            </div>

            <p><strong>Bloqueado</strong></p>
            
            <div class="input-field col s12 m4 l2">
                <div class="switch">
                    <label>
                        No<input type="checkbox" name="locked" <?php
                            if ($day['Locked']) {echo "checked";}
                        ?>>
                        <span class="lever"></span>
                        Sí
                    </label>
                </div>
            </div>

            <div class="input-field col s12">
                <button class="btn green" type="submit" name="action" value="day-config">Guardar</button>
            </div>
        </form>
        </div>

    </div>
</div>

</div>