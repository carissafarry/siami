<?php
/**
 * @var $this \app\includes\View
 * @var $checklist_id int
 * @var $checklist \app\admin\models\Checklist
 * @var $checklist_has_kriterias array \app\admin\models\ChecklistHasKriteria
 * @var $auditors array \app\admin\models\Auditor
 * @var $current_auditor_id int
 * @var $prev_checklist_has_kriterias array \app\admin\models\ChecklistHasKriteria
 * @var $same_prev_checklist_has_kriterias array \app\admin\models\ChecklistHasKriteria
 * @var $colors array
 */

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
                <div class="row mb-3">
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
                        <h6 class="mb-0"><small>No Identifikasi</small></h6>
                        <p><small><?= $checklist->no_identifikasi ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>No Revisi</small></h6>
                        <p><small><?= $checklist->no_revisi ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Area</small></h6>
                        <p><small><?= $checklist->area()->nama ?></small></p>
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
                    $no = 1;
                    foreach ($auditors as $auditor):
                    ?>
                        <div class="col-sm-6 col-12">
                            <h6 class="mb-0"><small>Auditor <?= $no ?></small></h6>
                            <p><small><?= $auditor->user()->nama ?> - <?= $auditor->user()->net_id ?></small></p>
                        </div>
                    <?php
                    $no++;
                    endforeach;
                    ?>
                    <?php if (count($auditors) < 3): ?>
                        <div class="col-sm-6 col-12">
                            <h6 class="mb-0"><small>Auditor 3</small></h6>
                            <p><small>-</small></p>
                        </div>
                    <?php endif; ?>
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>Status</small></h6>
                        <p><small><?= $checklist->status ?></small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (($prev_checklist_has_kriterias) && ($checklist->status_id >= 2)): ?>
    <div class="row my-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row d-flex justify-content-between">
                        <div class="col-sm-6 col-4">
                            <h6>Tinjauan Efektivitas Kriteria Tahun Sebelumnya</h6>
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
                                    Kriteria
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Efektivitas th lalu
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Catatan
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Ket Nilai
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Ket Auditee
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Data Pendukung
                                </th>
                                <?php if ($checklist->status_id >= 2): ?>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                        Tinjauan Efektifitas
                                    </th>
                                <?php endif; ?>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Aksi
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                            foreach ($same_prev_checklist_has_kriterias as $prev_checklist_has_kriteria):
//                            foreach ($prev_checklist_has_kriterias as $prev_checklist_has_kriteria):
                                $kriteria = $prev_checklist_has_kriteria->kriteria();
                                $checklist_auditor = $prev_checklist_has_kriteria->checklist_auditor();
                            ?>
                                <tr class="text-sm">
                                    <input type="hidden" name="checklist_kriteria_id" value="<?= $prev_checklist_has_kriteria->id ?>">
                                    <td class="center-table"> <?= $no ?> </td>
                                    <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(nl2br($kriteria->kriteria)) ?></td>
                                    <td class="center-table">
                                        <span class="badge bg-gradient-<?= (strtolower($prev_checklist_has_kriteria->ketidaksesuaian) == 'efektif') ? 'success' : 'danger' ?>" style="white-space: pre-wrap;"><?= ucwords($prev_checklist_has_kriteria->ketidaksesuaian) ?></span>
                                    </td>
                                    <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(nl2br(($kriteria->catatan ?: '-'))) ?></td>
                                    <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(nl2br(($kriteria->ket_nilai ?: '-'))) ?></td>
                                    <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(nl2br($prev_checklist_has_kriteria->ket_auditee ?: '-')) ?></td>
                                    <?php if (isset($prev_checklist_has_kriteria->data_pendukung)) :?>
                                        <td class="center-table">
                                            <a href="/auditor/checklist/view/<?= $prev_checklist_has_kriteria->id ?>" target="__blank" style="color: #d0261f; padding-inline: 0.5rem;">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        </td>
                                    <?php else: ?>
                                        <td class="center-table" style="white-space: pre-wrap">-</td>
                                    <?php endif; ?>
                                    <td class="center-table align-content-center">
                                        <?php if ($checklist->status_id >= 2): ?>
                                            <select class="form-select tinjauan_efektivitas_<?= $prev_checklist_has_kriteria->id ?>" name="tinjauan_efektivitas_<?= $prev_checklist_has_kriteria->id ?>" id="select_tinjauan_efektivitas_<?= $prev_checklist_has_kriteria->id ?>" onchange="submitTinjauanEfektivitas(<?= json_encode($prev_checklist_has_kriteria->id) ?>)" <?= ($checklist->status_id >= 3) ? 'disabled' : ''?> style="outline: none;">
                                                <option value="efektif">Efektif</option>
                                                <option value="tidak efektif">Tidak Efektif</option>
                                                <option value="closed">Closed</option>
                                                <option value="open">Open</option>
                                            </select>
                                        <?php endif; ?>
                                    </td>
                                    <td class="center-table align-content-center">
                                        <ul style="list-style: none; padding-left: 0;">
                                            <?php if ($checklist->status_id >= 2): ?>
                                                <li class="inline-icon"><a href="<?= \app\includes\App::getRoute() ?>/i/<?= $prev_checklist_has_kriteria->id ?>"><i class="fas fa-info-circle"></i></a></li>
                                            <?php endif; ?>
                                        </ul>
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


<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row d-flex justify-content-between">
                    <div class="col-sm-6 col-4">
                        <h6>Data Kriteria</h6>
                    </div>
                    <div class="col-sm-6 col-8 text-end">
                        <?php if (($checklist->status_id == 2) && ($auditors[0]->user_id == $current_auditor_id)): ?>
                        <form action="/auditor/checklist/submit" method="post">
                            <input type="hidden" name="checklist_id" value="<?= $checklist_id ?>">
                            <button type="submit" class="btn bg-gradient-warning">Submit Audit</button>
                        </form>
                        <?php endif; ?>
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
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Ket Nilai
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Keterangan Auditee
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Data Pendukung
                            </th>
                            <?php if ($checklist->status_id >= 2): ?>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Keterangan Auditor
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Nilai
                                </th>
                                <?php if ($checklist->status_id == 2) : ?>
                                    <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                        Aksi
                                    </th>
                                <?php endif; ?>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        foreach ($checklist_has_kriterias as $checklist_kriteria):
                            $kriteria = $checklist_kriteria->kriteria();
                            $checklist_auditor = $checklist_kriteria->checklist_auditor(['auditor_id' => $current_auditor_id]);
                        ?>
                            <tr class="text-sm">
                                <input type="hidden" name="checklist_kriteria_id" value="<?= $checklist_kriteria->id ?>">
                                <td class="center-table"> <?= $no ?> </td>
                                <td class="center-table" style="white-space: pre-wrap;"><span style="width: 10rem;"><?= html_entity_decode(nl2br($kriteria->kriteria)) ?></span></td>
                                <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(nl2br(($kriteria->catatan ?: '-'))) ?></td>
                                <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(nl2br(($kriteria->ket_nilai ?: '-'))) ?></td>
                                <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(nl2br(($checklist_kriteria->ket_auditee ?: '-'))) ?></td>
                                <td class="center-table">
                                    <?php if (isset($checklist_kriteria->data_pendukung)) :?>
                                        <a href="/auditor/checklist/view/<?= $checklist_kriteria->id ?>" target="__blank" style="color: #d0261f; padding-inline: 0.5rem;">
                                            <i class="fas fa-file"></i>
                                        </a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <?php if ($checklist->status_id >= 2): ?>
                                    <td class="center-table">
                                        <textarea class="form-control ket_auditor" name="ket_auditor_<?= $checklist_auditor->id ?>" id="ket_auditor_<?= $checklist_auditor->id ?>" rows="4" <?= ($checklist->status_id > 2) ? 'disabled' : ''?>><?= $checklist_auditor->ket_auditor ?></textarea>
                                    </td>
                                    <td class="center-table">
                                        <textarea class="form-control nilai" name="nilai_<?= $checklist_auditor->id ?>" id="nilai_<?= $checklist_auditor->id ?>" cols="5" style="width: 3rem;" <?= ($checklist->status_id > 2) ? 'disabled' : ''?>><?= $checklist_auditor->nilai ?></textarea>
                                    </td>
                                    <?php if ($checklist->status_id == 2) : ?>
                                    <td class="center-table align-content-center">
                                        <ul style="list-style: none; padding-left: 0;">
                                            <li class="inline-icon">
                                                <button type="submit" value="<?= $checklist_auditor->id ?>" class="btn-sm bg-transparent border-0 p-0 saveKriteriaData">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    </td>
                                    <?php endif; ?>
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
    <div class="div d-flex justify-content-between">
        <button onclick="history.back();" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</button>
        <?php if (($checklist->status_id == 2) && ($auditors[0]->user_id == $current_auditor_id)): ?>
            <form action="/auditor/checklist/submit" method="post">
                <input type="hidden" name="checklist_id" value="<?= $checklist_id ?>">
                <button type="submit" class="btn bg-gradient-warning">Submit Audit</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    function submitTinjauanEfektivitas(checklist_has_kriteria_id) {
        var tinjauan_efektivitas = $("#select_tinjauan_efektivitas_" + checklist_has_kriteria_id).val();

        $.ajax({
            type: 'POST',
            url: "/auditor/checklist/save-tinjauan-efektivitas",
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

    $(document).ready(function() {
        $('.saveKriteriaData').click(function () {
            var checklist_id = <?=json_encode($checklist_id)?>;
            var checklist_auditor_id = $(this).attr('value');
            var ket_auditor = $("#ket_auditor_" + checklist_auditor_id).val();
            var nilai = $("#nilai_" + checklist_auditor_id).val();

            var form_data = new FormData();
            form_data.append("id", checklist_auditor_id);
            form_data.append("ket_auditor", ket_auditor);
            form_data.append("nilai", nilai);

            $.ajax({
                type: 'POST',
                url: "/auditor/checklist/update/".concat(checklist_id, "/s/"),
                data: form_data,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.success === true) {
                        console.log(response);
                        Swal.fire('Sukses', response.message, "success");
                    } else {
                        console.log(response);
                        Swal.fire('Gagal', response.message, "error");
                    }
                },
            })
        });
    });
</script>