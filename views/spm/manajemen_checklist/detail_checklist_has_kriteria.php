<?php
/**
 * @var $this \app\includes\View
 * @var $checklist \app\admin\models\Checklist
 * @var $checklist_has_kriteria \app\admin\models\ChecklistHasKriteria
 * @var $colors array
 */

use app\includes\App;

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
                        <h6>Detail</h6>
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
                            <a href="/spm/manajemen-checklist/view/<?= $checklist_has_kriteria->id ?>" target="__blank" class="btn btn-block bg-gradient-warning btn-sm btn-icon">
                                <i class="fas fa-file-download"></i>
                                <span>Unduh Data Pendukung</span>
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Efektivitas</small></h6>
                        <span class="badge bg-gradient-<?= ($checklist_has_kriteria->ketidaksesuaian == 1) ? 'success' : 'danger' ?>" style="white-space: pre-wrap;"><?= html_entity_decode(nl2br(($checklist_has_kriteria->ketidaksesuaian == 1) ? 'Efektif' : 'Tidak Efektif')) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row text-left">
    <div class="div">
        <button onclick="history.back();" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</button>
    </div>
</div>
