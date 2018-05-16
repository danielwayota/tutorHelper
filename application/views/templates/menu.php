<nav class="nav-extended indigo darken-4">
    <div class="nav-wrapper">
        <a href="<?php echo base_url(); ?>" class="brand-logo">
            <i class="material-icons">school</i>Tutor Helper
        </a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger">
            <i class="material-icons">menu</i>
        </a>

        <ul id="nav-mobile" class="right hide-on-med-and-down">
        <!-- Render the main menu -->
        <?php
            $url_base = base_url() . 'index.php/pages/view/';
            $selected_page_id = 0;

            if (isset($config['selected_page_id']))
            {
                $selected_page_id = $config['selected_page_id'];
            }
        ?>
        <!-- Single menu element rendering -->
        <?php foreach ($pages as $page) : ?>

        <li class="<?php
            if ($page['IdPage'] === $selected_page_id) { echo 'active'; }
            ?>"
        >
            <a href="<?= $url_base ?><?= $page['IdPage'] ?>"><?=
                $page['Title']
            ?></a>
        </li>

        <?php endforeach; ?>
        </ul>
    </div>
</nav>

<ul class="sidenav" id="mobile-demo">

<!-- Single menu element rendering -->
<?php foreach ($pages as $page) : ?>

<li class="<?php
    if ($page['IdPage'] === $selected_page_id) { echo 'active'; }
    ?>"
>
    <a href="<?= $url_base ?><?= $page['IdPage'] ?>"><?=
        $page['Title']
    ?></a>
</li>

<?php endforeach; ?>

</ul>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, {});
});
</script>