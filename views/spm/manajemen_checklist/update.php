<?php
/**
 * @var $this \app\includes\View
 * @var $checklist \app\admin\models\Checklist
 * @var $auditors array \app\admin\models\Auditor
 * @var $checklist_has_kriterias array \app\admin\models\ChecklistHasKriteria
 * @var $prev_checklist_has_kriterias array \app\admin\models\ChecklistHasKriteria
 * @var $same_prev_checklist_has_kriterias array \app\admin\models\ChecklistHasKriteria
 * @var $colors array
 */

use app\includes\App;

$this->title = 'Checklist | Update';
$this->breadcrumbs = 'Checklist / Update';
$this->header_title = 'Update Checklist';
?>


<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Detail Checklist</h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <div class="row mb-4">
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>AMI</small></h6>
                        <p><small><?= $checklist->ami()->tahun ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Status Checklist</small></h6>
                        <span class="badge bg-gradient-<?= $colors[($checklist->status_id - 1) % count($colors)] ?>"><?= $checklist->status()->status ?></span>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Tanggal Terbit</small></h6>
                        <p><small><?= $checklist->tgl_terbit ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Nomor Identifikasi</small></h6>
                        <p><small><?= $checklist->no_identifikasi ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Nomor Revisi</small></h6>
                        <p><small><?= $checklist->no_revisi ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Area</small></h6>
                        <p><small><?= $checklist->area()->nama ?> <?= $checklist->area()->is_prodi == 1 ? $checklist->area()->jurusan : '' ?></small></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>Auditee</small></h6>
                        <p><small><?= $checklist->auditee()->user()->nama ?> - <?= $checklist->auditee()->user()->net_id ?></small></p>
                    </div>
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>Auditee Pengganti</small></h6>
                        <?php if ($checklist->auditee2()) : ?>
                            <p><small><?= $checklist->auditee2()->user()->nama ?: '' ?></small></p>
                        <?php else: ?>
                            <p><small>-</small></p>
                        <?php endif; ?>
                    </div>
                    <?php
                    $no_auditor=1;
                    foreach ($auditors as $auditor):
                        $user_auditor = $auditor->user();
                    ?>
                        <div class="col-sm-6 col-12">
                            <h6 class="mb-0"><small>Auditor <?= $no_auditor ?></small></h6>
                            <p><small><?= $user_auditor->nama ?> - <?= $user_auditor->net_id ?></small></p>
                        </div>
                    <?php
                    $no_auditor++;
                    endforeach;
                    ?>
                    <?php if (count($auditors) < 3): ?>
                        <div class="col-sm-6 col-12">
                            <h6 class="mb-0"><small>Auditor 3</small></h6>
                            <p><small>-</small></p>
                        </div>
                    <?php endif; ?>
                    <?php if ($checklist->status_id >= 3): ?>
                        <div class="col-sm-6 col-12">
                            <h6 class="mb-0"><small>Waktu Audit</small></h6>
                            <?php $current_date = date_create($checklist->waktu_audit); ?>
                            <p><small><?= date_format($current_date, "l, j F Y, H.i") . ' WIB' ?></small></p>
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
                        <h6>
                            Kriteria Checklist
                            <span class="text-primary">
                                <?= $checklist->area()->nama ?> <?= $checklist->area()->is_prodi == 1 ? $checklist->area()->jurusan : '' ?> <?= $checklist->ami()->tahun ?>
                            </span>
                        </h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2 p-0 m-3">
                <div class="table-responsive">
                    <table id="TABLE_2" class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                No
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Kriteria
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Catatan
                            </th>
                            <?php if ($checklist->status_id >= 3): ?>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Ket Auditee
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Data Pendukung
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Kesesuaian
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Aksi
                                </th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        foreach ($checklist_has_kriterias as $checklist_kriteria):
                            $kriteria = $checklist_kriteria->kriteria();
                            $checklist_auditor = $checklist_kriteria->checklist_auditor();
                            $is_last_year_kriteria = in_array($kriteria->kriteria, $same_prev_checklist_has_kriterias);
                        ?>
                            <tr class="text-sm">
                                <input type="hidden" name="checklist_kriteria_id" value="<?= $checklist_kriteria->id ?>">
                                <td class="center-table"> <?= $no ?> </td>
                                <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode($kriteria->kriteria) ?></td>
                                <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(($kriteria->catatan) ?: '-') ?></td>
                                <?php if ($checklist->status_id >= 3): ?>
                                    <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(($checklist_kriteria->ket_auditee) ?: '-') ?></td>
                                    <?php if (isset($checklist_kriteria->data_pendukung)) :?>
                                        <td class="center-table">
                                            <a href="<?= APP_PATH ?>/spm/manajemen-checklist/view/<?= $checklist_kriteria->id ?>" target="__blank" style="color: #d0261f; padding-inline: 0.5rem;">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        </td>
                                    <?php else: ?>
                                        <td class="center-table" style="white-space: pre-wrap">-</td>
                                    <?php endif; ?>
                                    <td class="center-table">
                                        <?php $is_sesuai = !((($checklist_kriteria->tidak_sesuai == 1) || ($checklist_kriteria->tidak_sesuai == null))); ?>
                                        <span class="badge bg-gradient-<?= $is_sesuai ? 'success' : 'danger'?>" style="white-space: pre-wrap;"><?= $is_sesuai ? 'Sesuai' : 'Tidak Sesuai' ?></span>
                                    </td>
                                <?php endif; ?>
                                <?php if ($checklist->status_id >= 3): ?>
                                    <td class="center-table align-content-center">
                                        <ul style="list-style: none; padding-left: 0;">
                                            <li class="inline-icon"><a href="<?= App::getRoute() ?>/i/<?= $checklist_kriteria->id ?>"><i class="fas fa-pen"></i></a></li>
                                        </ul>
                                    </td>
                                <?php endif; ?>

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
        <button onclick="history.back();" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</button>
    </div>
</div>