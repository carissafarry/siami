<?php
use app\includes\App;
?>

<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="/"><?= App::$app->user->role()->role ?></a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><?= $this->breadcrumbs ?></li>
            </ol>
            <h6 class="font-weight-bolder mb-0"><?= $this->header_title ?></h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            </div>
            <ul class="navbar-nav  justify-content-end">
                <?php if (!App::isGuest()) : ?>
                    <li class="nav-item d-flex align-items-center">
                        <a href="/profile" class="nav-link text-body font-weight-bold px-0">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">
                                <?= App::$app->user->nama ?>
                            </span>
                        </a>
                    </li>
                <?php endif ?>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item d-flex align-items-center" style="padding-left: 1rem">
                    <a href="<?= APP_PATH ?>/logout" class="nav-link text-body p-0">
                        <i class="fa fa-sign-out cursor-pointer"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->