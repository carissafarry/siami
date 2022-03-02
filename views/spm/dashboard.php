<?php
require_once dirname(__DIR__) . '/admin/components/header.php';
// echo $_ENV[ 'BASE_DIR'];
?>

<body class="g-sidenav-show bg-gray-100">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-left ms-3"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute right-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="../pages/dashboard.html">
                <img src="../contents/assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="...">
                <span class="ms-1 font-weight-bold">Soft UI Dashboard</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <?php
                require 'components/nav_item/nav_choosen.php';
                require 'components/nav_item/nav.php';
                ?>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
                </li>
                <?php
                require 'components/nav_item/profile.php'; ?>
            </ul>
        </div>
    </aside>
    <main class="main-content mt-1 border-radius-lg">
        <!-- Navbar -->
        <?php
        require 'components/navbar.php';
        ?>
        <!-- End Navbar -->
        <!-- Overview -->
        <div class="container-fluid py-4">
            <div class="row">
                <?php
                require 'components/overview/money.php';
                require 'components/overview/user.php';
                require 'components/overview/client.php';
                require 'components/overview/sales.php';
                ?>
            </div>
            <div class="row mt-4">
                <?php
                require 'components/card/large1.php';
                require 'components/card/large2.php';
                ?>
            </div>
            <div class="row mt-4">
                <?php
                require 'components/chart/bar.php';
                require 'components/chart/line.php';
                ?>
            </div>
            <div class="row mt-4">
                <?php
                require 'components/table/table1.php';
                require 'components/timeline/horizontal.php';
                ?>
            </div>
            <?php
            require 'components/footer.php';
            ?>
        </div>
        <!-- End Overview -->
    </main>
    <?php
    require 'components/configurator.php'; ?>
    <?php
    require 'components/scripts.php';
    ?>
    <script src="../contents/assets/js/pages/dashboard.js"></script>
</body>