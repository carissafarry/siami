<?php
/**
 * @var $this \app\includes\View
 * @var $ami \app\admin\models\Ami
 */

use app\includes\App;

$this->title = 'AMI | Detail';
$this->breadcrumbs = 'AMI / Detail';
$this->header_title = 'Detail AMI';
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Audit Mutu Internal Tahun <?= $ami->tahun ?></h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <div class="row mb-4">
                    <div class="col-lg-9 col-md-9 px-md-5">
                        <div class="row">
                            <div class="col-sm-6 col-4">
                                <h6 class="mb-0"><small>Kepala SPM</small></h6>
                                <p><small><?= $ami->spm()->user()->nama ?></small></p>
                            </div>
                            <div class="col-sm-6 col-4">
                                <h6 class="mb-0"><small>Periode</small></h6>
                                <p><small><?= $ami->tahun ?></small></p>
                            </div>
                            <div class="col-sm-6 col-4">
                                <h6 class="mb-0"><small>Jadwal Mulai</small></h6>
                                <p><small><?= $ami->jadwal_mulai ?></small></p>
                            </div>
                            <div class="col-sm-6 col-12">
                                <h6 class="mb-0"><small>Jadwal Selesai</small></h6>
                                <p><small><?= $ami->jadwal_selesai ?></small></p>
                            </div>
                            <div class="col-sm-6 col-12">
                                <h6 class="mb-0"><small>Status Tindak Lanjut</small></h6>
                                <p><small><?= ($ami->is_tindak_lanjut == 1) ? 'Aktif' : 'Inaktif'; ?></small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-left">
                    <div class="div">
                        <button onclick="history.back();" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
