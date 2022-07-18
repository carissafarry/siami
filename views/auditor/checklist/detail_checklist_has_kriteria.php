<?php
/**
 * @var $this \app\includes\View
 * @var $checklist \app\admin\models\Checklist
 * @var $checklist_id \app\admin\models\Checklist->id
 * @var $checklist_has_kriteria \app\admin\models\ChecklistHasKriteria
 * @var $last_year_ami int \app\admin\models\Ami
 * @var $checklist_auditors array \app\admin\models\ChecklistAuditor
 * @var $checklist_auditor \app\admin\models\ChecklistAuditor
 * @var $prev_checklist \app\admin\models\Checklist
 * @var $is_used_in_prev_checklist_has_kriteria bool
 * @var $prev_checklist_has_kriteria \app\admin\models\ChecklistHasKriteria
 * @var $prev_checklist_auditors array \app\admin\models\ChecklistAuditor
 * @var $prev_ami_period \app\admin\models\Ami
 * @var $colors array
 */

$this->title = 'Checklist | Detail Laporan';
$this->breadcrumbs = 'Checklist / Detail Laporan';
$this->header_title = 'Detail Laporan Checklist per Kriteria';
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Detail Kriteria</h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="mb-0"><small>Kriteria</small></h6>
                        <p><small style="white-space: pre-wrap;"><?= html_entity_decode(nl2br($checklist_has_kriteria->kriteria()->kriteria)) ?></small></p>
                    </div>
                    <div class="col-12">
                        <h6 class="mb-0"><small>Keterangan Nilai</small></h6>
                        <p><small style="white-space: pre-wrap;"><?= html_entity_decode(nl2br(($checklist_has_kriteria->kriteria()->ket_nilai))) ?></small></p>
                    </div>
                    <div class="col-12">
                        <h6 class="mb-0"><small>Catatan</small></h6>
                        <?php if (isset($checklist_has_kriteria->kriteria()->catatan)) : ?>
                            <p><small style="white-space: pre-wrap;"><?= html_entity_decode(nl2br($checklist_has_kriteria->kriteria()->catatan)) ?></small></p>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </div>
                    <?php if ($checklist_has_kriteria->checklist()->status_id >= 2): ?>
                        <div class="col-12">
                            <h6 class="mb-0"><small>Keterangan Auditee</small></h6>
                            <?php if ($checklist_has_kriteria->ket_auditee): ?>
                                <p><small style="white-space: pre-wrap;"><?= html_entity_decode(nl2br($checklist_has_kriteria->ket_auditee)) ?></small></p>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </div>
                        <div class="col-12">
                            <h6 class="mb-0"><small>Data Pendukung</small></h6>
                            <?php if ($checklist_has_kriteria->data_pendukung): ?>
                                <a href="<?= APP_PATH ?>/auditor/checklist/view/<?= $checklist_has_kriteria->id ?>" target="__blank" class="btn btn-block bg-gradient-warning btn-sm btn-icon">
                                    <i class="fas fa-file-download"></i>
                                    <span>Unduh Data Pendukung</span>
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (($checklist_has_kriteria->checklist()->status_id >= 3) || ($last_year_ami != $checklist_has_kriteria->checklist()->ami()->tahun)): ?>
                        <div class="col-12">
                            <h6 class="mb-0"><small>Kesesuaian</small></h6>
                            <span class="badge bg-gradient-<?= $checklist_has_kriteria->tidak_sesuai == 1 ? 'danger' : 'success' ?>" style="white-space: pre-wrap;"><?= $checklist_has_kriteria->tidak_sesuai == 1 ? 'Tidak Sesuai' : 'Sesuai' ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($is_used_in_prev_checklist_has_kriteria): ?>
    <div class="row my-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>Hasil Audit Tahun <span class="text-warning"><?= $prev_ami_period->tahun ?></span></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-sm-5 px-4">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="mb-0"><small>Catatan</small></h6>
                            <?php if (isset($prev_checklist_has_kriteria->kriteria()->catatan)) : ?>
                                <p><small style="white-space: pre-wrap;"><?= html_entity_decode(nl2br($prev_checklist_has_kriteria->kriteria()->catatan)) ?></small></p>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </div>
                        <div class="col-12">
                            <h6 class="mb-0"><small>Keterangan Auditee</small></h6>
                            <?php if ($prev_checklist_has_kriteria->ket_auditee): ?>
                                <p><small style="white-space: pre-wrap;"><?= html_entity_decode(nl2br($prev_checklist_has_kriteria->ket_auditee)) ?></small></p>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </div>
                        <div class="col-12">
                            <h6 class="mb-0"><small>Data Pendukung</small></h6>
                            <?php if ($prev_checklist_has_kriteria->data_pendukung): ?>
                                <a href="<?= APP_PATH ?>/spm/manajemen-checklist/view/<?= $prev_checklist_has_kriteria->id ?>" target="__blank" class="btn btn-block bg-gradient-warning btn-sm btn-icon">
                                    <i class="fas fa-file-download"></i>
                                    <span>Unduh Data Pendukung</span>
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <h6 class="mb-0"><small>Kesesuaian</small></h6>
                            <span class="badge bg-gradient-<?= $prev_checklist_has_kriteria->tidak_sesuai == 1 ? 'danger' : 'success' ?>" style="white-space: pre-wrap;"><?= $prev_checklist_has_kriteria->tidak_sesuai == 1 ? 'Tidak Sesuai' : 'Sesuai' ?></span>
                        </div>
                        <?php if (($checklist_has_kriteria->checklist()->status_id == 2) && ($prev_checklist_has_kriteria->tidak_sesuai == 1)): ?>
                            <div class="col-12">
                                <h6 class="mb-0"><small>Tinjauan Efektivitas</small></h6>
                                <select class="form-select prev_tinjauan_efektivitas_<?= $prev_checklist_has_kriteria->id ?>" name="prev_tinjauan_efektivitas_<?= $prev_checklist_has_kriteria->id ?>" id="select_prev_tinjauan_efektivitas_<?= $prev_checklist_has_kriteria->id ?>" onchange="submitTinjauanEfektivitas(<?= json_encode($prev_checklist_has_kriteria->id) ?>)" style="outline: none; width: 30vw;">
                                    <option value="">Pilih</option>
                                    <option value="efektif" <?= ($prev_checklist_has_kriteria->tinjauan_efektivitas == "efektif") ? "selected" : '' ?>>Efektif</option>
                                    <option value="tidak efektif" <?= ($prev_checklist_has_kriteria->tinjauan_efektivitas == "tidak efektif") ? "selected" : '' ?>>Tidak Efektif</option>
                                </select>
                            </div>
                        <?php endif; ?>
                        <?php if (($checklist_has_kriteria->checklist()->status_id >= 3)): ?>
                            <div class="col-12">
                                <h6 class="mb-0"><small>Efektivitas Hingga Tahun Ini</small></h6>
                                <span class="badge bg-gradient-<?= ($prev_checklist_has_kriteria->tinjauan_efektivitas == 'efektif') ? 'success' : 'danger' ?>" style="white-space: pre-wrap;"><?= $prev_checklist_has_kriteria->tinjauan_efektivitas ?: 'tidak efektif' ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row mb-4">
                        <h6 class="mb-0"><small>Detail Penilaian Auditor</small></h6>
                        <div class="table-responsive">
                            <table id="TABLE_1" class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                        No
                                    </th>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                        Auditor
                                    </th>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                        Keterangan Auditor / Ketidaksesuaian
                                    </th>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                        Nilai
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                foreach ($prev_checklist_auditors as $prev_checklist_auditor):
                                    ?>
                                    <tr class="text-sm">
                                        <input type="hidden" name="checklist_kriteria_id" value="<?= $prev_checklist_auditor->id ?>">
                                        <td class="center-table"> <?= $no ?> </td>
                                        <td class="center-table">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-xs"><?= $prev_checklist_auditor->auditor()->user()->nama ?></h6>
                                                    <p class="text-xs text-secondary mb-0"><?= $prev_checklist_auditor->auditor()->user()->net_id ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="center-table">
                                            <?php if ($prev_checklist_auditor->ket_auditor): ?>
                                                <span><?= html_entity_decode(nl2br($prev_checklist_auditor->ket_auditor)) ?></span>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td class="center-table">
                                            <?php if ($prev_checklist_auditor->nilai): ?>
                                                <span><?= html_entity_decode(nl2br($prev_checklist_auditor->nilai)) ?></span>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php if ($prev_checklist_has_kriteria->tidak_sesuai == 1): ?>
                        <div class="row mb-4">
                            <h6><small>Rencana Tindakan Koreksi</small></h6>
                            <textarea class="form-control prev_tindak_lanjut" name="prev_tindak_lanjut" id="prev_tindak_lanjut" rows="4" disabled><?= $prev_checklist_has_kriteria->tindak_lanjut ?></textarea>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($checklist_has_kriteria->checklist()->status_id == 2) : ?>
    <form action="<?= APP_PATH ?>/auditor/checklist/update/<?= $checklist_id ?>/i/<?= $checklist_has_kriteria->id ?>/save-audit" method="post" id="formSaveAuditKriteria">
        <input type="hidden" name="checklist_auditor_id" value="<?= $checklist_auditor->id ?>">
        <div class="row my-4">
            <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row d-flex justify-content-between">
                            <div class="col-sm-6 col-4">
                                <h6>Penilaian Audit</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-sm-5 px-4">
                        <div class="row mb-4">
                            <div class="">
                                <h6 class="mb-0"><small>Keterangan Auditor</small></h6>
                                <textarea class="form-control ket_auditor" name="ket_auditor" id="ket_auditor" rows="4" placeholder="Silakan mengisi Keterangan Auditor" <?= ($checklist_has_kriteria->checklist()->status_id >= 3) ? 'disabled' : '' ?>><?= html_entity_decode($checklist_auditor->ket_auditor) ?></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="" style="max-width: fit-content;">
                                <h6 class="mb-0"><small>Nilai</small></h6>
                                <input type="number" name="nilai" id="nilai" class="form-control" value="<?= $checklist_auditor->nilai ?>">
                            </div>
                        </div>
                        <div class="row text-right" style="justify-content: right;">
                            <button type="submit" class="btn btn-sm bg-gradient-warning" style="max-width: fit-content;">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php endif; ?>

<?php if ($checklist_has_kriteria->checklist()->status_id >= 3): ?>
<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row d-flex justify-content-between">
                    <div class="col-sm-6 col-4">
                        <h6>Detail Penilaian Auditor <span class="text-warning"><?= $checklist_has_kriteria->checklist()->ami()->tahun ?></h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2 p-0 m-3">
                <div class="table-responsive">
                    <table id="TABLE_1" class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                No
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Auditor
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Keterangan Auditor / Ketidaksesuaian
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Nilai
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        foreach ($checklist_auditors as $checklist_auditor):
                        ?>
                            <tr class="text-sm">
                                <input type="hidden" name="checklist_kriteria_id" value="<?= $checklist_auditor->id ?>">
                                <td class="center-table"> <?= $no ?> </td>
                                <td class="center-table">
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-xs"><?= $checklist_auditor->auditor()->user()->nama ?></h6>
                                            <p class="text-xs text-secondary mb-0"><?= $checklist_auditor->auditor()->user()->net_id ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="center-table">
                                    <?php if ($checklist_auditor->ket_auditor): ?>
                                        <span><?= html_entity_decode(nl2br($checklist_auditor->ket_auditor)) ?></span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td class="center-table">
                                    <?php if ($checklist_auditor->nilai): ?>
                                        <span><?= html_entity_decode(nl2br($checklist_auditor->nilai)) ?></span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
if ($checklist_has_kriteria->tidak_sesuai == 1):
    if ($last_year_ami == $checklist_has_kriteria->checklist()->ami()->tahun):
        if ($checklist_has_kriteria->checklist()->status_id >= 5):
            ?>
            <div class="row my-4">
                <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h6>Rencana Tindakan Koreksi <span class="text-warning"><?= $checklist_has_kriteria->checklist()->ami()->tahun ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-sm-5 px-4">
                            <div class="row mb-4">
                                <textarea class="form-control tindak_lanjut" name="tindak_lanjut" id="tindak_lanjut" rows="4" disabled><?= $checklist_has_kriteria->tindak_lanjut ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="row my-4">
            <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Rencana Tindakan Koreksi</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-sm-5 px-4">
                        <div class="row mb-4">
                            <textarea class="form-control tindak_lanjut" name="tindak_lanjut" id="tindak_lanjut" rows="4" disabled><?= $checklist_has_kriteria->tindak_lanjut ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="row text-left">
    <div class="div">
        <?php if ($last_year_ami == $checklist_has_kriteria->checklist()->ami()->tahun): ?>
            <a href="<?= APP_PATH ?>/auditor/checklist/update/<?= $checklist_has_kriteria->checklist()->id ?>" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</a>
        <?php else: ?>
            <button onclick="history.back();" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</button>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    function submitTinjauanEfektivitas(checklist_has_kriteria_id) {
        var tinjauan_efektivitas = $("#select_prev_tinjauan_efektivitas_" + checklist_has_kriteria_id).val();
        var app_path = <?= json_encode(APP_PATH) ?>;

        $.ajax({
            type: 'POST',
            url: app_path + "/auditor/checklist/save-tinjauan-efektivitas",
            data: {
                'id': checklist_has_kriteria_id,
                'tinjauan_efektivitas': tinjauan_efektivitas
            },
            success: function(response) {
                if (response.success === true) {
                    Swal.fire('Sukses', response.message, "success");
                }
            },
        })
    }
</script>