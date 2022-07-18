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
                        <h6 class="mb-0"><small>No Identifikasi</small></h6>
                        <p><small><?= $checklist->no_identifikasi ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Nomor Revisi</small></h6>
                        <p><small><?= $checklist->no_revisi ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Area</small></h6>
                        <p><small><?= $checklist->area()->nama ?> <?= $checklist->area()->is_prodi == 1 ? $checklist->area()->jurusan : ''?></small></p>
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
                    <?php if ($checklist->status_id >= 3): ?>
                        <div class="col-sm-6 col-12">
                            <h6 class="mb-0"><small>Waktu Audit</small></h6>
                            <?php
                                $current_date = date_create($checklist->waktu_audit);
                            ?>
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
                            <?php if ($checklist->status_id >= 2): ?>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Ket Auditee
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Data Pendukung
                                </th>
                            <?php endif; ?>
                            <?php if ($checklist->status_id >= 3): ?>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Kesesuaian
                                </th>
                            <?php endif; ?>
<!--                            --><?php //if ($checklist->status_id >= 2): ?>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Aksi
                                </th>
<!--                            --><?php //endif; ?>
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
                                <?php if ($checklist->status_id >= 2): ?>
                                    <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(nl2br(($checklist_kriteria->ket_auditee ?: '-'))) ?></td>
                                    <td class="center-table">
                                        <?php if (isset($checklist_kriteria->data_pendukung)) :?>
                                            <a href="<?= APP_PATH ?>/auditor/checklist/view/<?= $checklist_kriteria->id ?>" target="__blank" style="color: #d0261f; padding-inline: 0.5rem;">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                                <?php if ($checklist->status_id >= 3): ?>
                                    <td class="center-table">
                                        <span class="badge bg-gradient-<?= $checklist_kriteria->tidak_sesuai == 1 ? 'danger' : 'success' ?>" style="white-space: pre-wrap;"><?= $checklist_kriteria->tidak_sesuai == 1 ? 'Tidak Sesuai' : 'Sesuai' ?></span>
                                    </td>
                                <?php endif; ?>
<!--                                --><?php //if ($checklist->status_id >= 2): ?>
                                    <td class="center-table align-content-center">
                                        <ul style="list-style: none; padding-left: 0;">
                                            <li class="inline-icon"><a href="<?= APP_PATH ?>/auditor/checklist/update/<?= $checklist_kriteria->checklist()->id ?>/i/<?= $checklist_kriteria->id ?>"><i class="fas fa-info-circle"></i></a></li>
                                        </ul>
                                    </td>
<!--                                --><?php //endif; ?>
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
            <form action="<?= APP_PATH ?>/auditor/checklist/submit" method="post">
                <input type="hidden" name="checklist_id" value="<?= $checklist_id ?>">
                <button type="submit" class="btn bg-gradient-warning">Submit Audit</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    function submitTinjauanEfektivitas1(checklist_has_kriteria_id) {
        var tinjauan_efektivitas = $("#select_tinjauan_efektivitas_" + checklist_has_kriteria_id).val();
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