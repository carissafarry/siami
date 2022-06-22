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
                <form action="/spm/ami/add" method="post">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="spm_id" class="h6 text-sm form-control-label">Kepala SPM</label>
                                <select class="form-select" name="spm_id" id="spm_id">
                                    <?php foreach ($spms as $spm): ?>
                                        <option value="<?= $spm->user_id ?>"><?= $spm->user()->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
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
                                <label for="jadwal_mulai" class="h6 text-sm form-control-label">Jadwal Mulai</label>
                                <input name="jadwal_mulai" class="form-control <?= $rule->hasError('jadwal_mulai') ? 'is-invalid' : '' ?>" type="date" id="jadwal_mulai">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('jadwal_mulai') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jadwal_selesai" class="h6 text-sm form-control-label">Jadwal Selesai</label>
                                <input name="jadwal_selesai" class="form-control <?= $rule->hasError('jadwal_selesai') ? 'is-invalid' : '' ?>" type="date" id="jadwal_selesai">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('jadwal_selesai') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="is_tindak_lanjut" class="h6 text-sm form-check-label" >Aktifkan Tindak Lanjut</label>
                            <div class="form-check form-switch">
                                <input name="is_tindak_lanjut" class="form-check-input" type="checkbox" id="is_tindak_lanjut" onchange="set_tindak_lanjut(this)">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="/<?= strtolower(App::$app->user->role->role) ?>/ami" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</a>
                        <button type="submit" class="btn btn-sm bg-gradient-warning">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function set_tindak_lanjut(obj) {
        // const a = obj.textContent = obj.checked ? 'on' : 'off';
        obj.textContent = obj.checked ? 'on' : 'off';
        // console.log(a)
        // console.log(document.getElementById("is_tindak_lanjut2").value);
        // console.log(obj.value);

    }
    // $.post("/",
    //     {
    //         total: getTotalFromSomewhere,
    //     }
    // );
</script>
