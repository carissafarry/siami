<?php
/**
 * @var $this \app\includes\View
 * @var $amis array \app\admin\models\Ami
 * @var $standar \app\admin\models\Standar
 * @var $rule \app\admin\rules\spm\manajemen_kriteria\StandarRule
 */

use app\includes\App;

$this->title = 'Manajemen Kriteria | Edit Standar';
$this->breadcrumbs = 'Manajemen Kriteria / Edit Standar';
$this->header_title = 'Edit Standar';
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Edit Standar</h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <form action="" method="post">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun" class="h6 text-sm form-control-label">Tahun</label>
                                <select class="form-select" name="tahun" id="tahun">
                                    <option value="<?= $standar->tahun ?>"><?= $standar->tahun ?></option>
                                    <?php
                                    foreach ($amis as $ami):
                                        if ($ami->tahun != $standar->tahun):
                                            ?>
                                            <option value="<?= $ami->tahun ?>"><?= $ami->tahun ?></option>
                                        <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode" class="h6 text-sm form-control-label">Kode Standar</label>
                                <input name="kode" class="form-control <?= $rule->hasError('kode') ? 'is-invalid' : '' ?>" type="text" id="kode" value="<?= $standar->kode ?>">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('kode') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="standar" class="h6 text-sm form-control-label">Standar</label>
                                <textarea name="standar" class="form-control <?= $rule->hasError('standar') ? 'is-invalid' : '' ?>" id="standar" rows="5"><?= $standar->standar ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('standar') ?>
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
