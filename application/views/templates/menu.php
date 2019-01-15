<?php
    // Admin menu composition
    $template = array(
        array(
            'name' => 'Agregar contenido',
            'requireSuperUser' => true,
            'url' => base_url() . 'index.php/pages/list'
        ),
        array(
            'name' => 'Usuarios',
            'requireSuperUser' => true,
            'url' => base_url() . 'index.php/users/list'
        ),
        array(
            'name' => 'Gestionar calendario',
            'requireSuperUser' => true,
            'url' => base_url() . 'index.php/admin/calendar/month'
        ),
        array(
            'name' => 'Calendario del alumnado',
            'requireSuperUser' => false,
            'url' => base_url() . 'index.php/student/calendar/month'
        ),
        array(
            'name' => 'Informe de mes',
            'requireSuperUser' => true,
            'url' => base_url() . 'index.php/report'
        ),
    );
    $admin_menu_items = array();
    if ($this->session->userdata('logged_in'))
    {
        foreach($template as $item)
        {
            $insert = true;
            if ($item['requireSuperUser'])
            {

                if (!$this->session->userdata('IsSuperAdmin'))
                {
                    $insert = false;
                }

            }
            if ($insert)
            {
                array_push($admin_menu_items, $item);
            }
        }
    }

?>

<nav class="nav-extended indigo darken-4">
    <div class="nav-wrapper">
        <a href="<?php echo base_url(); ?>" class="brand-logo">
        <i class="material-icons">school</i>
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
            <!-- Login/Logout buttons -->
            <?php if ($this->session->userdata('logged_in')) : ?>
                <a class="btn indigo darken-6"
                    href="<?php echo base_url() ?>index.php/users/logout">
                    <i class="material-icons left">person</i>Salir
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

    <!-- ADMIN MENU -->
    <?php if (!empty($admin_menu_items)) : ?>
    <div class="nav-content hide-on-med-and-down">
        <ul class="tabs tabs-transparent">
            <?php foreach ($admin_menu_items as $item) : ?>
            <li class="tab">
                <a href="<?= $item['url'] ?>"><?= $item['name'] ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
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
    <!-- ADMIN MENU -->
    <?php if (!empty($admin_menu_items)) : ?>
    <li><div class="divider"></div></li>
    <?php foreach ($admin_menu_items as $item) : ?>
    <li class="tab">
        <a href="<?= $item['url'] ?>"><?= $item['name'] ?></a>
    </li>
    <?php endforeach; ?>
    <?php endif; ?>

    <li><div class="divider"></div></li>
    <li>
    <!-- Login/Logout buttons -->
    <?php if ($this->session->userdata('logged_in')) : ?>
        <a href="<?php echo base_url() ?>index.php/users/logout">
            <i class="material-icons">person</i>Salir
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