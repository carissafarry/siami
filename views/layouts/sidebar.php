<?php
use app\includes\App;
?>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-left ms-3 bg-white">
    <div class="sidenav-header" style="height: 7rem">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute right-0 top-0 d-none d-xl-none"
           aria-hidden="true" id="iconSidenav"></i>
        <a class="px-3 py-2 m-0 d-flex justify-content-evenly" href="/dashboard">
            <img src="/contents/assets/img/logo-PENS.png" style="max-width: 100%; max-height: 5rem;" alt="...">
        </a>
        <hr class="horizontal dark mt-0">
    </div>
    <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <?php $component = \app\includes\Component::init() ?>
            <?= $component->navItem('Dashboard', '/dashboard', '
                <i class="fas fa-home"></i>
            ', false) ?>

            <!-- Menu SPM -->
            <?php if (App::$app->user->role()->role == 'SPM'): ?>
                <?= $component->navItem('Manajemen User', '/manajemen-user', '
                    <i class="fas fa-solid fa-users"></i>
                ') ?>
                <?= $component->navItem('Audit Mutu Internal', '/ami', '
                    <i class="fas fa-solid fa-file-alt"></i>
                ') ?>
                <?= $component->navItem('Manajemen Kriteria', '/manajemen-kriteria', '
                    <i class="fas fa-clipboard-list"></i>
                ') ?>
                <?= $component->navItem('Manajemen Checklist', '/manajemen-checklist', '
                    <i class="fas fa-th-list"></i>
                ') ?>
            <?php endif; ?>

            <!-- Menu Auditee -->
            <?php if (App::$app->user->role()->role == 'Auditee'): ?>
                <?= $component->navItem('Checklist', '/checklist', '
                    <i class="fas fa-th-list"></i>
                ') ?>
            <?php endif; ?>

            <!-- Menu Auditor -->
            <?php if (App::$app->user->role()->role == 'Auditor'): ?>
                <?= $component->navItem('Checklist', '/checklist', '
                <i class="fas fa-th-list"></i>
            ') ?>
            <?php endif; ?>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
            </li>
            <?= $component->navItem('Profile', '/profile', '
                <i class="fas fa-user"></i>
            ', false) ?>
        </ul>
    </div>
</aside>