<?php
/**
 * @var $this \app\includes\View
 * @var $standar \app\admin\models\Standar
 */

use app\includes\App;

$this->title = 'Kriteria | Detail Standar';
$this->breadcrumbs = 'Kriteria / Detail Standar';
$this->header_title = 'Detail Standar';
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Standar</h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <div class="row mb-4">
                    <div class="col-lg-9 col-md-9 px-md-5">
                        <div class="row">
                            <div class="col-sm-6 col-4">
                                <h6 class="mb-0"><small>Tahun</small></h6>
                                <p><small><?= $standar->tahun ?></small></p>
                            </div>
                            <div class="col-sm-6 col-4">
                                <h6 class="mb-0"><small>Kode Standar</small></h6>
                                <p><small><?= $standar->kode ?></small></p>
                            </div>
                            <div class="col-sm-6 col-12">
                                <h6 class="mb-0"><small>Standar</small></h6>
                                <p><small><?= $standar->standar ?></small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-left">
                    <div class="div">
                        <a href="/<?= strtolower(App::$app->user->role->role) ?>/manajemen-kriteria" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
