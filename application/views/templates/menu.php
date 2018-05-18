<nav class="nav-extended indigo darken-4">
    <div class="nav-wrapper">
        <a href="<?php echo base_url(); ?>" class="brand-logo">
            <i class="material-icons">school</i>Tutor Helper
        </a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger">
            <i class="material-icons">menu</i>
        </a>

        <!-- === MAIN MENU === -->
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
            <li>
            <?php if ($this->session->userdata('logged_in')) : ?>
                <a class="btn indigo darken-6"
                    href="<?php echo base_url() ?>index.php/users/logout">
                    <i class="material-icons left">person_outline</i>Salir
                </a>
            <?php else : ?>
                <a class="btn indigo darken-6"
                    href="<?php echo base_url() ?>index.php/users/login">
                    <i class="material-icons left">person</i>Entrar
                </a>
            <?php endif; ?>
            </li>
        </ul>
        <!-- === END MAIN MENU === -->
    </div>
</nav>

<!-- === MOBILE MENU === -->
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
    <li><div class="divider"></div></li>
    <li>
    <?php if ($this->session->userdata('logged_in')) : ?>
        <a href="<?php echo base_url() ?>index.php/users/logout">
            <i class="material-icons">person_outline</i>Salir
        </a>
    <?php else : ?>
        <a href="<?php echo base_url() ?>index.php/users/login">
            <i class="material-icons">person</i>Entrar
        </a>
    <?php endif; ?>
    </li>
</ul>
<!-- === END MOBILE MENU === -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, {});
});
</script>