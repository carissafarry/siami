<!--
=========================================================
* Soft UI Dashboard - v1.0.2
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/soft-ui-dashboard/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<?php
require_once APP_ROOT . '/views/layouts/header.php';
?>

<body class="g-sidenav-show   bg-white">
<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg  blur blur-rounded top-0  z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                <div class="container-fluid">
                    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon mt-2">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                      </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navigation">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item">
                                    <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="../pages/dashboard.html">
                                        SISTEM INFORMASI AUDIT MUTU INTERNAL
                                    </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
    </div>
</div>
<section>
    <div class="page-header section-height-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                    <div class="card card-plain mt-8">
                        <div class="card-header pb-0 text-left bg-transparent">
                            <h3 class="font-weight-bolder text-info text-gradient">Selamat Datang!</h3>
                        </div>
                        <?php
                        /** @var $rule \app\admin\rules\auth\LoginRule */
                        ?>
                        <div class="card-body">
                            <?php $form = \app\includes\form\Form::begin(\app\includes\App::getRoute(), "post") ?>
                                <?= $form->field($rule, 'email') ?>
                                <?= $form->field($rule, 'password')->passwordField() ?>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Log In</button>
                                </div>
                            <?= \app\includes\form\Form::end() ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                        <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('/contents/assets/img/Pens-Campus.jpeg')"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
<footer class="footer py-4 fixed-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-4 mx-auto text-center d-flex justify-content-between">
                <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                    SIAMI @<?= date('Y') ?>
                </a>
                <a href="https://www.pens.ac.id/" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
                    Politeknik Elektronika Negeri Surabaya
                </a>
            </div>
        </div>
    </div>
</footer>
<!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
<!--   Core JS Files   -->
<?php
require_once APP_ROOT . '/views/layouts/scripts.php';
?>
</body>

</html>