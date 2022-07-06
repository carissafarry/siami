<?php
/**
 * @var $this \app\includes\View
 * @var $checklist \app\admin\models\Checklist
 * @var $checklist_has_kriteria \app\admin\models\ChecklistHasKriteria
 * @var $last_year_ami int \app\admin\models\Ami
 * @var $checklist_auditors array \app\admin\models\ChecklistAuditor
 * @var $checklist_auditor_nilais array \app\admin\models\ChecklistAuditor->nilai
 * @var $colors array
 */

$this->title = 'Checklist | Detail Laporan';
$this->breadcrumbs = 'Checklist / Detail Laporan';
$this->header_title = 'Detail Laporan Checklist';
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
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Kriteria</small></h6>
                        <p><small style="white-space: pre-wrap;"><?= html_entity_decode(nl2br($checklist_has_kriteria->kriteria()->kriteria)) ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Keterangan Nilai</small></h6>
                        <p><small style="white-space: pre-wrap;"><?= html_entity_decode(nl2br(($checklist_has_kriteria->kriteria()->ket_nilai))) ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Catatan</small></h6>
                        <?php if (isset($checklist_has_kriteria->kriteria()->catatan)) : ?>
                            <p><small style="white-space: pre-wrap;"><?= html_entity_decode(nl2br($checklist_has_kriteria->kriteria()->catatan)) ?></small></p>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Keterangan Auditee</small></h6>
                        <?php if ($checklist_has_kriteria->data_pendukung): ?>
                            <p><small style="white-space: pre-wrap;"><?= html_entity_decode(nl2br($checklist_has_kriteria->ket_auditee)) ?></small></p>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Data Pendukung</small></h6>
                        <?php if ($checklist_has_kriteria->data_pendukung): ?>
                            <a href="<?= APP_PATH ?>/auditee/checklist/view/<?= $checklist_has_kriteria->id ?>" target="__blank" class="btn btn-block bg-gradient-warning btn-sm btn-icon">
                                <i class="fas fa-file-download"></i>
                                <span>Unduh Data Pendukung</span>
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </div>
                    <?php if ($checklist_has_kriteria->checklist()->status_id >= 4): ?>
                        <div class="col-md-4 col-sm-6 col-12">
                            <h6 class="mb-0"><small>Kesesuaian</small></h6>
                            <span class="badge bg-gradient-<?= $checklist_has_kriteria->tidak_sesuai == 1 ? 'danger' : 'success' ?>" style="white-space: pre-wrap;"><?= $checklist_has_kriteria->tidak_sesuai == 1 ? 'Tidak Sesuai' : 'Sesuai' ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($last_year_ami != $checklist_has_kriteria->checklist()->ami()->tahun): ?>
                        <div class="col-md-4 col-sm-6 col-12">
                            <h6 class="mb-0"><small>Efektivitas Hingga Tahun Ini</small></h6>
                            <span class="badge bg-gradient-<?= (strtolower($checklist_has_kriteria->tinjauan_efektivitas) == 'efektif') ? 'success' : 'danger' ?>" style="white-space: pre-wrap;"><?= $checklist_has_kriteria->tinjauan_efektivitas ?: 'tidak efektif' ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($checklist->status_id >= 4): ?>
<div class="row my-4">
    <form action="<?= APP_PATH ?>/auditee/checklist/update/<?= $checklist->id ?>/i/<?= $checklist_has_kriteria->id ?>" method="post" id="formTindakLanjut">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row d-flex justify-content-between">
                        <div class="col-sm-6 col-4">
                            <h6>Hasil Audit <?php ($checklist_has_kriteria->tidak_sesuai == 1) ? ' dan Rencana Tindakan Koreksi' : '' ?></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-sm-5 px-4">
                    <div class="row mb-4">
                        <div class="col-md-4 col-sm-6 col-12">
                            <h6 class="mb-0"><small>Keterangan Auditor / Ketidaksesuaian</small></h6>
                            <p>
                                <small style="white-space: pre-wrap;">
                                    <?php foreach ($checklist_auditors as $checklist_auditor): ?>
                                        <?php if ($checklist_auditor->ket_auditor != ''): ?>
                                            <?= $checklist_auditor->ket_auditor ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </small>
                            </p>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <h6 class="mb-0"><small>Nilai Akhir</small></h6>
                            <p><small style="white-space: pre-wrap;"><?= max($checklist_auditor_nilais) ?></small></p>
                        </div>
                    </div>
                    <?php if (($checklist_has_kriteria->checklist()->status_id >= 4) && ($checklist_has_kriteria->tidak_sesuai == 1)): ?>
                        <div class="row mb-4">
                            <h6 class="mb-0"><small>Rencana Tindakan Koreksi</small></h6>
                            <textarea class="form-control tindak_lanjut" name="tindak_lanjut" id="tindak_lanjut" rows="4" placeholder="Silakan mengisi Rencana Tindakan Koreksi" <?= ($checklist->status_id > 4) ? 'disabled' : '' ?>><?= $checklist_has_kriteria->tindak_lanjut ?></textarea>
                        </div>
                        <?php if ($checklist->status_id == 4): ?>
                            <div class="row text-right" style="justify-content: right;">
                                <button type="submit" class="btn btn-sm bg-gradient-warning" style="max-width: fit-content;">Simpan</button>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>
</div>
<?php endif; ?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <form enctype="multipart/form-data" action="<?= APP_PATH ?>/auditee/checklist/update/<?= $checklist->id ?>/i/<?= $checklist_has_kriteria->id ?>/input-audit-kriteria" method="post" id="formInputAuditKriteria">
                <div class="card-header pb-0">
                    <div class="row d-flex justify-content-between">
                        <div class="col-sm-6 col-4">
                            <h6>Input Audit</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-sm-5 px-4">
                    <div class="row mb-4">
                        <h6 class="mb-0"><small>Keterangan Auditee</small></h6>
                        <textarea class="form-control ket_auditee" name="ket_auditee" id="ket_auditee" rows="4" placeholder="Silakan mengisi Keterangan Auditee" <?= ($checklist->status_id >= 3) ? 'disabled' : '' ?>><?= html_entity_decode($checklist_has_kriteria->ket_auditee) ?></textarea>
                    </div>
                    <div class="row mb-4">
                        <h6 class="mb-0"><small>Data Pendukung</small></h6>
                        <?php if ($checklist_has_kriteria->data_pendukung):?>
                            <?php if ($checklist->status_id < 3): ?>
                                <input type="file" name="data_pendukung" id="data_pendukung">
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($checklist->status_id >= 3): ?>
                                -
                            <?php else: ?>
                                <input type="file" name="data_pendukung" id="data_pendukung">
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="row text-right" style="justify-content: right;">
                        <button type="submit" class="btn btn-sm bg-gradient-warning" style="max-width: fit-content;">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row text-left">
    <div class="div">
        <a href="<?= APP_PATH ?>/auditee/checklist/update/<?= $checklist->id ?>" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</a>
    </div>
</div>
