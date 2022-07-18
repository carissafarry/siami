<?php
use app\includes\App;
?>

<!doctype html>
<html lang="en">

<?php require APP_ROOT . '/views/layouts/header.php'; ?>

<body class="g-sidenav-show bg-gray-100">
    <?php require_once APP_ROOT . '/views/layouts/sidebar.php'; ?>
    <main class="main-content mt-1 border-radius-lg">
        <?php require_once APP_ROOT . '/views/layouts/navbar.php'; ?>
        <div class="container-fluid py-1" style="min-height: 80vh;">
            <!-- Alert -->
            <?php if (App::$app->session->getFlash('success')) :  ?>
                <div class="alert alert-success text-white alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-text"><strong>Success!</strong> <?= App::$app->session->getFlash('success') ?></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (App::$app->session->getFlash('failed')) :  ?>
                <div class="alert alert-danger text-white alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-text"><strong>Failed!</strong> <?= App::$app->session->getFlash('failed') ?></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            {{content}}
            <?php require  APP_ROOT . '/views/layouts/footer.php'; ?>
        </div>
    </main>
<!--    --><?php //require_once APP_ROOT . '/views/layouts/configurator.php'; ?>
    <?php require_once APP_ROOT . '/views/layouts/scripts.php'; ?>
    <?php if ($this->is_dashboard == true): ?>
        <script src="/contents/assets/js/pages/dashboard.js"></script>
    <?php endif; ?>
</body>
</html>