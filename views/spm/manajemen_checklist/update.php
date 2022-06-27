<?php
/**
 * @var $this \app\includes\View
 * @var $checklist \app\admin\models\Checklist
 * @var $areas array \app\admin\models\Area
 * @var $auditees array \app\admin\models\Auditee
 */

use app\includes\App;

$this->title = 'Manajemen Checklist | Edit Checklist';
$this->breadcrumbs = 'Manajemen Checklist / Edit Checklist';
$this->header_title = 'Tambah Checklist';
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Tambah Checklist</h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <?php /** @var $rule \app\admin\rules\spm\manajemen_checklist\AddChecklistRule */ ?>
                <form action="" method="post">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_terbit" class="h6 text-sm form-control-label">Tanggal Terbit</label>
                                <input name="tgl_terbit" class="form-control <?= $rule->hasError('tgl_terbit') ? 'is-invalid' : '' ?>" type="date" id="tgl_terbit">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('tgl_terbit') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_identifikasi" class="h6 text-sm form-control-label">Nomor Identifikasi</label>
                                <input name="no_identifikasi" class="form-control <?= $rule->hasError('no_identifikasi') ? 'is-invalid' : '' ?>" type="text" id="no_identifikasi">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('kode') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="standar_id" class="h6 text-sm form-control-label">Kode Standar</label>
                                <select class="form-select" name="standar_id" id="standar_id">
                                    <option value="<?= $kriteria->standar()->id ?>"><?= $kriteria->standar()->kode ?></option>
                                    <?php foreach ($standars as $standar): ?>
                                        <option value="<?= $standar->id ?>"><?= $standar->kode ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode" class="h6 text-sm form-control-label">Kode Kriteria</label>
                                <input name="kode" class="form-control <?= $rule->hasError('kode') ? 'is-invalid' : '' ?>" type="text" id="kode" value="<?= $kriteria->kode ?>">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('kode') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kriteria" class="h6 text-sm form-control-label">Kriteria</label>
                                <textarea name="kriteria" class="form-control <?= $rule->hasError('kriteria') ? 'is-invalid' : '' ?>" id="kriteria" rows="5"><?= $kriteria->kriteria ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('kriteria') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ket_nilai" class="h6 text-sm form-control-label">Keterangan Nilai</label>
                                <textarea name="ket_nilai" class="form-control <?= $rule->hasError('ket_nilai') ? 'is-invalid' : '' ?>" id="ket_nilai" rows="5"><?= $kriteria->ket_nilai ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('ket_nilai') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="catatan" class="h6 text-sm form-control-label">Catatan</label>
                                <textarea name="catatan" class="form-control <?= $rule->hasError('catatan') ? 'is-invalid' : '' ?>" id="catatan" rows="5"><?= $kriteria->catatan ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('catatan') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="/<?= strtolower(App::$app->user->role()->role) ?>/manajemen-kriteria" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</a>
                        <button type="submit" class="btn btn-sm bg-gradient-warning">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
