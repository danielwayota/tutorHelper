<nav class="nav-extended indigo darken-4">
    <div class="nav-wrapper">
        <a href="<?php echo base_url(); ?>" class="brand-logo center">Logo</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger">
            <i class="material-icons">menu</i>
        </a>

        <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="<?php echo base_url(); ?>">Home</a></li>
        </ul>
    </div>
    <div class="nav-content">
        <ul class="tabs tabs-transparent center">
            <li class="tab"><a href="<?php echo base_url(); ?>">Home</a></li>
        </ul>
    </div>
</nav>

<ul class="sidenav" id="mobile-demo">
    <li><a href="<?php echo base_url(); ?>">Home</a></li>
</ul>

<script>
document.addEventListener('DOMContentLoaded', function() {
var elems = document.querySelectorAll('.sidenav');
var instances = M.Sidenav.init(elems, {});
});
</script>