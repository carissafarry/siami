<?php
/**
 * @var $this \app\includes\View
 * @var $ami \app\admin\models\Ami
 * @var $spms array \app\admin\models\Spm
 * @var $rule \app\admin\rules\spm\ami\UpdateAmiRule
 */

use app\includes\App;

$this->title = 'AMI | Edit AMI';
$this->breadcrumbs = 'AMI / Edit AMI';
$this->header_title = 'Edit AMI';

$head_of_ami = $ami->spm()->user();
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Edit AMI</h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <form action="" method="post">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="spm_id" class="h6 text-sm form-control-label">Kepala SPM</label>
                                <select class="form-select" name="spm_id" id="spm_id">
                                    <option value="<?= $ami->spm_id ?>"><?= $head_of_ami->nama ?> - <?= $head_of_ami->net_id ?></option>
                                    <?php
                                    foreach ($spms as $spm):
                                        if ($spm->user_id != $ami->spm_id):
                                    ?>
                                        <option value="<?= $spm->user_id ?>"><?= $spm->user()->nama ?></option>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun" class="h6 text-sm form-control-label">Tahun</label>
                                <input name="tahun" class="form-control <?= $rule->hasError('tahun') ? 'is-invalid' : '' ?>" type="text" id="tahun" value="<?= $ami->tahun ?>" disabled>
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('tahun') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="audit_mulai" class="h6 text-sm form-control-label">Jadwal Mulai</label>
                                <input name="audit_mulai" class="form-control <?= $rule->hasError('audit_mulai') ? 'is-invalid' : '' ?>" type="date" id="audit_mulai" value="<?= $ami->audit_mulai ?>">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('audit_mulai') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="audit_selesai" class="h6 text-sm form-control-label">Jadwal Selesai</label>
                                <input name="audit_selesai" class="form-control <?= $rule->hasError('audit_selesai') ? 'is-invalid' : '' ?>" type="date" id="audit_selesai" value="<?= $ami->audit_selesai ?>">
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
