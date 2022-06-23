<?php
/**
 * @var $this \app\includes\View
 * @var $checklist \app\admin\models\Checklist
 * @var $amis array \app\admin\models\Ami
 * @var $statuses array \app\admin\models\Status
 * @var $areas array \app\admin\models\Area
 * @var $auditee_users array \app\admin\models\Auditee
 * @var $auditor_users array \app\admin\models\Auditor
 * @var $rule \app\admin\rules\spm\manajemen_checklist\AddChecklistRule
 */

use app\includes\App;

$this->title = 'Manajemen Checklist | Edit Checklist';
$this->breadcrumbs = 'Manajemen Checklist / Tambah Checklist';
$this->header_title = 'Tambah Checklist';
?>

<form action="/spm/manajemen-checklist/add" method="post" id="form_update_checklist">
    <div class="row my-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-body px-sm-5 px-4">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ami_id" class="h6 text-sm form-control-label required-field">Tahun AMI</label>
                                <select class="form-select" name="ami_id" id="ami_id" onchange="updateData()">
                                    <?php foreach ($amis as $ami): ?>
                                        <option value="<?= $ami->id ?>"><?= $ami->tahun ?> - <?= $ami->spm()->user()->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?= $rule->getFirstError('ami_id') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status_id" class="h6 text-sm form-control-label required-field">Status AMI</label>
                                <select class="form-select" name="status_id" id="status_id">
                                    <?php foreach ($statuses as $status): ?>
                                        <option value="<?= $status->id ?>"><?= $status->status ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?= $rule->getFirstError('status_id') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_terbit" class="h6 text-sm form-control-label required-field">Tanggal Terbit</label>
                                <input name="tgl_terbit" class="form-control <?= $rule->hasError('tgl_terbit') ? 'is-invalid' : '' ?>" type="date" id="tgl_terbit" value="<?= date('Y-m-d'); ?>">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('tgl_terbit') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_identifikasi" class="h6 text-sm form-control-label required-field">Nomor Identifikasi</label>
                                <input name="no_identifikasi" class="form-control <?= $rule->hasError('no_identifikasi') ? 'is-invalid' : '' ?>" type="text" id="no_identifikasi">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('no_identifikasi') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_revisi" class="h6 text-sm form-control-label required-field">Nomor Revisi</label>
                                <input name="no_revisi" class="form-control <?= $rule->hasError('no_revisi') ? 'is-invalid' : '' ?>" type="text" id="no_revisi">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('no_revisi') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="area_id" class="h6 text-sm form-control-label required-field">Area</label>
                                <select class="form-select" name="area_id" id="area_id" onchange="updateData()">
                                    <option value="">Pilih</option>
                                    <?php foreach ($areas as $area): ?>
                                        <option value="<?= $area->id ?>"><?= $area->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?= $rule->getFirstError('area_id') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="auditee_id" class="h6 text-sm form-control-label required-field">Auditee</label>
                                <select class="form-select" name="auditee_id" id="auditee_id">
                                    <option value="">Pilih Area</option>
                                    <?php foreach ($auditee_users as $auditee): ?>
                                        <option value="<?= $auditee->id ?>"><?= $auditee->nama ?> - (<?= $auditee->net_id ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?= $rule->getFirstError('auditee_id') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="auditee2_id" class="h6 text-sm form-control-label">Auditee Pengganti</label>
                                <select class="form-select" name="auditee2_id" id="auditee2_id">
                                    <option value="">Pilih</option>
                                    <?php foreach ($auditee_users as $auditee): ?>
                                        <option value="<?= $auditee->id ?>"><?= $auditee->nama ?> - (<?= $auditee->net_id ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?= $rule->getFirstError('auditee2_id') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="auditor1_id" class="h6 text-sm form-control-label required-field">Auditor 1</label>
                                <select class="form-select" name="auditor1_id" id="auditor1_id">
                                    <option value="">Pilih Area</option>
                                    <?php foreach ($auditor_users as $auditor): ?>
                                        <option value="<?= $auditor->id ?>"><?= $auditor->nama ?> - (<?= $auditor->net_id ?>) </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?= $rule->getFirstError('auditor1_id') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="auditor2_id" class="h6 text-sm form-control-label required-field">Auditor 2</label>
                                <select class="form-select" name="auditor2_id" id="auditor2_id">
                                    <option value="">Pilih Area</option>
                                    <?php foreach ($auditor_users as $auditor): ?>
                                        <option value="<?= $auditor->id ?>"><?= $auditor->nama ?> - (<?= $auditor->net_id ?>) </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?= $rule->getFirstError('auditor2_id') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="auditor3_id" class="h6 text-sm form-control-label">Auditor 3</label>
                                <select class="form-select" name="auditor3_id" id="auditor3_id">
                                    <option value="">Pilih</option>
                                    <?php foreach ($auditor_users as $auditor): ?>
                                        <option value="<?= $auditor->id ?>"><?= $auditor->nama ?> - (<?= $auditor->net_id ?>) </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?= $rule->getFirstError('auditor3_id') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-body px-sm-5 px-4 w-75">
                    <div class="row mt-3" id="input-kriteria">
                        <div class="form-group">
                            <label for="kriteria_1" class="h6 text-sm form-control-label required-field">Kriteria</label>
                            <div class="d-flex flex-row">
                                <input name="kriteria_1" class="form-control <?= $rule->hasError('kriteria_1') ? 'is-invalid' : '' ?>" type="text" id="kriteria_1" placeholder="Masukkan kode Kriteria ke-1">
                                <div class="align-self-center px-3 cursor-pointer">
                                    <a id="add-kriteria" onclick="add_kriteria_field()"><i class="fas fa-plus"></i></a>
                                </div>
                                <div class="invalid-feedback d-block">
                                    <?= $rule->getFirstError('kriteria_1') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="/<?= strtolower(App::$app->user->role->role) ?>/manajemen-checklist" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</a>
                        <button type="submit" class="btn btn-sm bg-gradient-warning">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var input_kriteria = document.getElementById('input-kriteria');
    var add_kriteria = document.getElementById('add-kriteria');
    var count_input = 2;

    function updateData() {
        var url = '/spm/manajemen-checklist/update-area-data';
        var ami_id = $('#ami_id').val();
        var area_id = $('#area_id').val();

        $.post(url, {
            area_id: area_id,
            ami_id: ami_id,
        })
        .done(function(jqXHR) {
            // console.log(jqXHR.auditee_users);
            // console.log(jqXHR.auditor_users);
            $("#auditee_id").empty();
            if (jqXHR.auditee_users.length == 0) {
                $("#auditee_id").append($('<option>', {
                    value: '',
                    text : 'Data Kosong',
                }));
            }

            $("#auditee2_id").empty().append($('<option>', {
                value: '',
                text : 'Pilih',
            }));
            $.each(jqXHR.auditee_users, function (i, val) {
                $('#auditee_id').append($('<option>', {
                    value: val.id,
                    text : val.nama.concat(' - (', val.net_id, ')'),
                }));
                $('#auditee2_id').append($('<option>', {
                    value: val.id,
                    text : val.nama.concat(' - (', val.net_id, ')'),
                }));
            });

            $("#auditor1_id").empty();
            $("#auditor2_id").empty();
            if (jqXHR.auditor_users.length == 0) {
                $("#auditor1_id").append($('<option>', {
                    value: '',
                    text : 'Data Kosong',
                }));
                $("#auditor2_id").append($('<option>', {
                    value: '',
                    text : 'Data Kosong',
                }));
            }

            $("#auditor3_id").empty().append($('<option>', {
                value: '',
                text : 'Pilih',
            }));
            $.each(jqXHR.auditor_users, function (i, val) {
                $('#auditor1_id').append($('<option>', {
                    value: val.id,
                    text : val.nama.concat(' - (', val.net_id, ')'),
                }));
                $('#auditor2_id').append($('<option>', {
                    value: val.id,
                    text : val.nama.concat(' - (', val.net_id, ')'),
                }));
                $('#auditor3_id').append($('<option>', {
                    value: val.id,
                    text : val.nama.concat(' - (', val.net_id, ')'),
                }));
            });
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log(arguments);
        });
    }
</script>