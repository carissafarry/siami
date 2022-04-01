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
        <div class="container-fluid py-4" style="min-height: 80vh;">
            {{content}}
            <?php require  APP_ROOT . '/views/layouts/footer.php'; ?>
        </div>
    </main>
    <?php require_once APP_ROOT . '/views/layouts/configurator.php'; ?>
    <?php require_once APP_ROOT . '/views/layouts/scripts.php'; ?>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/contents/assets/js/pages/dashboard.js"></script>
</body>
</html>