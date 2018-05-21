<!-- Materialize Compiled and minified JavaScript -->
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js">
</script>
<!-- OnLoad scripts -->
<script>
</script>

<script>
    let html = `<?php echo $this->session->flashdata('notification') ?>`;
    let color = `<?php echo $this->session->flashdata('notification_color') ?>` || 'green';

    if (html) {
        setTimeout(() => {
            M.toast({html: html, classes: color, displayLength: 4000})
        }, 250);
    }
    
</script>

</body>
</html>