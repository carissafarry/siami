<?php
/**
 * @var $this \app\includes\View
 * @var $ami \app\admin\models\Ami
 * @var $spms array \app\admin\models\Spm
 * @var $rule \app\admin\rules\spm\ami\AddAmiRule
 */

use app\includes\App;

$this->title = 'AMI | Add AMI';
$this->breadcrumbs = 'AMI / Add AMI';
$this->header_title = 'Tambah AMI';
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-body px-sm-5 px-4">
                <form action="<?= App::getRoute() ?>" method="post">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="spm_id" class="h6 text-sm form-control-label">Kepala SPM</label>
                                <select class="form-select" name="spm_id" id="spm_id">
                                    <?php foreach ($spms as $spm): ?>
                                        <option value="<?= $spm->user_id ?>"><?= $spm->user()->nama ?> - <?= $spm->user()->net_id ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?= $rule->getFirstError('spm_id') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun" class="h6 text-sm form-control-label">Tahun</label>
                                <input name="tahun" class="form-control <?= $rule->hasError('tahun') ? 'is-invalid' : '' ?>" type="text" id="tahun">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('tahun') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="audit_mulai" class="h6 text-sm form-control-label">Jadwal Mulai</label>
                                <input name="audit_mulai" class="form-control <?= $rule->hasError('audit_mulai') ? 'is-invalid' : '' ?>" type="date" id="audit_mulai" value="<?= date('Y-m-d'); ?>">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('audit_mulai') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="audit_selesai" class="h6 text-sm form-control-label">Jadwal Selesai</label>
                                <input name="audit_selesai" class="form-control <?= $rule->hasError('audit_selesai') ? 'is-invalid' : '' ?>" type="date" id="audit_selesai" value="<?= date('Y-m-d'); ?>">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('audit_selesai') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button onclick="history.back();" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</button>
                        <button type="submit" class="btn btn-sm bg-gradient-warning">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>