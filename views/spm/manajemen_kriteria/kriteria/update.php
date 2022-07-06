<?php
/**
 * @var $this \app\includes\View
 * @var $kriteria \app\admin\models\Kriteria
 * @var $standars array \app\admin\models\Standar
 * @var $amis array \app\admin\models\Ami
 * @var $rule \app\admin\rules\spm\manajemen_kriteria\KriteriaRule
 */

use app\includes\App;

$this->title = 'Manajemen Kriteria | Edit Kriteria';
$this->breadcrumbs = 'Manajemen Kriteria / Edit Kriteria';
$this->header_title = 'Edit Kriteria';
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Edit Kriteria</h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <form action="" method="post">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun" class="h6 text-sm form-control-label required-field">Tahun</label>
                                <select class="form-select" name="tahun" id="tahun" onchange="updateStandarData($(this).val())">
                                    <?php
                                    foreach ($amis as $ami):
                                        if ($ami->tahun == $kriteria->tahun):
                                    ?>
                                        <option value="<?= $ami->tahun ?>"><?= $ami->tahun ?></option>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                    <?php
                                    foreach ($amis as $ami):
                                        if ($ami->tahun != $kriteria->tahun):
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
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="standar_id" class="h6 text-sm form-control-label required-field">Kode Standar</label>
                                <select class="form-select" name="standar_id" id="standar_id">
                                    <?php
                                    foreach ($standars as $standar):
                                        if ($standar->id == $kriteria->standar_id):
                                    ?>
                                        <option value="<?= $kriteria->standar_id ?>"><?= $kriteria->standar()->kode ?> - <?= $standar->standar ?></option>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                    <?php
                                    foreach ($standars as $standar):
                                        if ($standar->id != $kriteria->standar_id):
                                            ?>
                                            <option value="<?= $standar->id ?>"><?= $standar->kode ?> - <?= $standar->standar ?></option>
                                        <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode" class="h6 text-sm form-control-label required-field">Kode Kriteria</label>
                                <input name="kode" class="form-control <?= $rule->hasError('kode') ? 'is-invalid' : '' ?>" type="text" id="kode" value="<?= $kriteria->kode ?>">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('kode') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kriteria" class="h6 text-sm form-control-label required-field">Kriteria</label>
                                <textarea name="kriteria" class="form-control <?= $rule->hasError('kriteria') ? 'is-invalid' : '' ?>" id="kriteria" rows="5"><?= html_entity_decode($kriteria->kriteria) ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('kriteria') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ket_nilai" class="h6 text-sm form-control-label required-field">Keterangan Nilai</label>
                                <textarea name="ket_nilai" class="form-control <?= $rule->hasError('ket_nilai') ? 'is-invalid' : '' ?>" id="ket_nilai" rows="5"><?= html_entity_decode($kriteria->ket_nilai) ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('ket_nilai') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="catatan" class="h6 text-sm form-control-label">Catatan</label>
                                <textarea name="catatan" class="form-control <?= $rule->hasError('catatan') ? 'is-invalid' : '' ?>" id="catatan" rows="5"><?= html_entity_decode($kriteria->catatan) ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('catatan') ?>
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

<script type="text/javascript">
    function updateStandarData(tahun) {
        var app_path = <?= json_encode(APP_PATH) ?>
        var url = app_path + '/spm/manajemen-kriteria/k/update-standar-data';

        $.post(url, {
            tahun: tahun,
        }, function (data) {
            console.log(tahun + ' Sent!')
        })
        .done(function(jqXHR) {
            $("#standar_id").empty();
            $.each(jqXHR.standars, function (i, val) {
                $('#standar_id').append($('<option>', {
                    value: val.id,
                    text : val.kode.concat(' - ', val.standar),
                }));
            });
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log(arguments);
        });
    }
</script>