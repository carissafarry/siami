<?php
/**
 * @var $this \app\includes\View
 * @var $checklist \app\admin\models\Checklist
 * @var $checklist_has_kriteria \app\admin\models\ChecklistHasKriteria
 * @var $last_year_ami int \app\admin\models\Ami
 * @var $checklist_auditors array \app\admin\models\ChecklistAuditor
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
                            <a href="<?= APP_PATH ?>/auditor/checklist/view/<?= $checklist_has_kriteria->id ?>" target="__blank" class="btn btn-block bg-gradient-warning btn-sm btn-icon">
                                <i class="fas fa-file-download"></i>
                                <span>Unduh Data Pendukung</span>
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </div>
                    <?php if (($checklist_has_kriteria->checklist()->status_id >= 3) || ($last_year_ami != $checklist_has_kriteria->checklist()->ami()->tahun)): ?>
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


<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row d-flex justify-content-between">
                    <div class="col-sm-6 col-4">
                        <h6>Detail Penilaian Auditor</h6>
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

<div class="row text-left">
    <div class="div">
        <?php if ($last_year_ami == $checklist_has_kriteria->checklist()->ami()->tahun): ?>
            <a href="<?= APP_PATH ?>/auditor/checklist/update/<?= $checklist_has_kriteria->checklist()->id ?>" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</a>
        <?php else: ?>
            <button onclick="history.back();" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</button>
        <?php endif; ?>
    </div>
</div>
