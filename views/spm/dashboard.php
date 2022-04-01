<?php
/** @var $this \app\includes\View */
$this->title = 'Dashboard';
$this->breadcrumbs = 'Dashboard';
$this->header_title = $this->breadcrumbs;
?>

<div class="row">
    <?php
    require APP_ROOT . '/views/components/overview/money.php';
    require APP_ROOT . '/views/components/overview/user.php';
    require APP_ROOT . '/views/components/overview/client.php';
    require APP_ROOT . '/views/components/overview/sales.php';
    ?>
</div>
<div class="row mt-4">
    <?php
    require  APP_ROOT . '/views/components/card/large1.php';
    require  APP_ROOT . '/views/components/card/large2.php';
    ?>
</div>
<div class="row mt-4">
    <?php
    require  APP_ROOT . '/views/components/chart/bar.php';
    require  APP_ROOT . '/views/components/chart/line.php';
    ?>
</div>
<div class="row my-4">
    <?php
    require  APP_ROOT . '/views/components/table/table1.php';
    require  APP_ROOT . '/views/components/timeline/horizontal.php';
    ?>
</div>
