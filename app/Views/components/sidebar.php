<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == '') ? "" : "collapsed" ?>" href="/">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li><!-- End Home Nav -->

        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'kuliner' || uri_string() == '') ? "" : "collapsed" ?>" href="<?= base_url('kuliner') ?>">
                <i class="bi bi-shop"></i>
                <span>Eksplorasi Kuliner</span>
            </a>
        </li>

        <?php if (session()->get('isLoggedIn')): ?>
        <li class="nav-item">
            <a class="nav-link <?php echo (strpos(uri_string(), 'kontributor') !== false) ? "" : "collapsed" ?>" href="<?= base_url('kontributor/dashboard') ?>">
                <i class="bi bi-person-badge"></i>
                <span>Panel Kontributor</span>
            </a>
        </li>
        <?php endif; ?>

        <?php
        if (session()->get('role') == 'admin') {
        ?>
        <li class="nav-heading">Admin Kuliner</li>
        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'admin') ? "" : "collapsed" ?>" href="<?= base_url('admin') ?>">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard Kuliner</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'admin/kategori') ? "" : "collapsed" ?>" href="<?= base_url('admin/kategori') ?>">
                <i class="bi bi-tags"></i>
                <span>Kategori</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (uri_string() == 'admin/tag') ? "" : "collapsed" ?>" href="<?= base_url('admin/tag') ?>">
                <i class="bi bi-hash"></i>
                <span>Tag</span>
            </a>
        </li>
        <?php
        }
        ?>
    </ul>
</aside><!-- End Sidebar-->