<div class="container">
<?php
    $url_base = base_url() . 'index.php/pages';
?>
<div class="card">
    <div class="card-content">
    <?php echo form_open($url_base.'/create') ?>
        <h4 class="mb-3">Crear contenido:</h4>
        
        <div class="input-field">
            <input type="text" id="title" name="title" required />
            <label for="title">Título</label>
        </div>

        <div class="input-field">
            <input type="number" id="position" name="position" value="0" />
            <label for="position">Posición</label>
        </div>

        <div class="input-field">
            <textarea id="content" name="content"></textarea>
        </div>

        <div class="input-field mt-3">
            <a class="btn grey" href="<?php echo $url_base . '/list' ?>"><i class="material-icons">keyboard_backspace</i></a>
            <button class="btn green" type="submit"><i class="material-icons">check</i></button>
        </div>
    </form>
    </div>
</div>

</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.13/tinymce.min.js'></script>
<script>
tinymce.init({
    selector: '#content',
    plugins: ["code", "link"]
});
</script>