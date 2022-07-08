<?php
/**
 * @var $this \app\includes\View
 * @var $checklist \app\admin\models\Checklist
 * @var $checklist_has_kriterias array \app\admin\models\ChecklistHasKriteria
 * @var $auditors array \app\admin\models\Auditor
 * @var $checklist_id int
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
                <div class="row">
                    <div class="col-sm-6 col-4">
                        <h6>Data Kriteria</h6>
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
                                Kode Kriteria
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
                            <?php if ($checklist->status_id >= 3) : ?>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Kesesuaian
                                </th>
                            <?php endif; ?>
                            <?php if ($checklist->status_id >= 4) : ?>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Ket Auditor / Ketidaksesuaian
                                </th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                    Nilai Akhir
                                </th>
                            <?php endif; ?>
<!--                            --><?php //if ($checklist->status_id != 3): ?>
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
                        ?>
                            <tr class="text-sm">
                                <input type="hidden" name="checklist_kriteria_id" value="<?= $checklist_kriteria->id ?>">
                                <td class="center-table" style="white-space: pre-wrap;"> <?= $no ?> </td>
                                <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(nl2br($kriteria->kode)) ?></span></td>
                                <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(nl2br($kriteria->kriteria)) ?></span></td>
                                <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(nl2br(($kriteria->catatan ?: '-'))) ?></td>
                                <td class="center-table" style="white-space: pre-wrap;"><?= html_entity_decode(nl2br(($kriteria->ket_nilai ?: '-'))) ?></td>
                                <?php if ($checklist->status_id >= 3) : ?>
                                    <td class="center-table">
                                        <span class="badge bg-gradient-<?= $checklist_kriteria->tidak_sesuai == 1 ? 'danger' : 'success' ?>" style="white-space: pre-wrap;"><?= $checklist_kriteria->tidak_sesuai == 1 ? 'Tidak Sesuai' : 'Sesuai' ?></span>
                                    </td>
                                <?php endif; ?>
                                <?php
                                if ($checklist->status_id >= 4) :
                                    $checklist_auditors = $checklist_kriteria->checklist_auditors();
                                    $nilais = $checklist_kriteria->checklist_auditors([], 'nilai');
                                ?>
                                    <td class="center-table" style="white-space: pre-wrap;">
                                        <?php foreach ($checklist_auditors as $checklist_auditor): ?>
                                            <?= html_entity_decode(nl2br($checklist_auditor->ket_auditor)) ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <td class="center-table" style="white-space: pre-wrap;"><?= max($nilais) ?></td>
                                <?php endif; ?>
<!--                                --><?php //if ($checklist->status_id != 3): ?>
                                    <td class="center-table align-content-center">
                                        <ul style="list-style: none; padding-left: 0;">
                                            <li class="inline-icon"><a href="<?= App::getRoute() ?>/i/<?= $checklist_kriteria->id ?>"><i class="fas fa-info-circle"></i></a></li>
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
        <?php if ($checklist->status_id == 4): ?>
            <div class="">
                <form action="<?= APP_PATH ?>/auditee/checklist/update/<?= $checklist->id ?>/submit-rtm" method="post" id="formSubmitTindakLanjut">
                    <input type="hidden" name="checklist_id" value="<?= $checklist->id ?>">
                    <button type="submit" class="btn btn-sm bg-gradient-success">Submit</button>
                </form>
            </div>
        <?php endif; ?>
        <?php if ($checklist->status_id == 1): ?>
            <div class="">
                <form action="<?= APP_PATH ?>/auditee/checklist/update/<?= $checklist->id ?>/submit-audit" method="post" id="formSubmitAudit">
                    <input type="hidden" name="checklist_id" value="<?= $checklist->id ?>">
                    <button type="submit" class="btn btn-sm bg-gradient-success">Submit</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.submitButton').click(function () {
            var app_path = <?= json_encode(APP_PATH) ?>;
            var checklist_id = <?=json_encode($checklist_id)?>;
            var checklist_kriteria_id = $(this).attr('value');
            var ket_auditee = $("#ket_auditee_" + checklist_kriteria_id).val();
            var data_pendukung = $('#data_pendukung_' + checklist_kriteria_id).prop('files')[0];

            var form_data = new FormData();
            form_data.append("id", checklist_kriteria_id);
            form_data.append("ket_auditee", ket_auditee);
            if (typeof data_pendukung !== 'undefined') {
                form_data.append("data_pendukung", data_pendukung);
            }

            $.ajax({
                type: 'POST',
                url: app_path + "/auditee/checklist/update/".concat(checklist_id, "/s/"),
                data: form_data,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success === true) {
                        console.log(response);
                        Swal.fire('Sukses', response.message, "success");
                    } else {
                        console.log(response);
                        Swal.fire('Gagal', response.message, "error");
                    }
                },
            })
            // .done(function(jqXHR) {
            //     console.log(jqXHR);
            //     Swal.fire('Sukses', jqXHR.message, "success");
            // })
            // .fail(function (jqXHR, textStatus, errorThrown) {
            //     console.log(arguments);
            //     Swal.fire('Gagal', jqXHR.message, "error");
            // });
        });
    });

    function submit2(checklist_kriteria_id) {
        var checklist_id = <?=json_encode($checklist_id)?>;
        var ket_auditee = $("#ket_auditee_" + checklist_kriteria_id).val();
        var data_pendukung = $("#data_pendukung_" + checklist_kriteria_id).val();
        var filename = data_pendukung.replace(/^.*\\/, "");

        var url = "/auditee/checklist/detail/".concat(checklist_id, "/s/");

        $.post(url, {
                id: checklist_kriteria_id,
                ket_auditee: ket_auditee,
                data_pendukung: filename,
            }, function (data) {
                console.log(checklist_kriteria_id + ' Sent!')
            }
        )
        .done(function(jqXHR) {
            console.log(jqXHR);
            Swal.fire('Sukses', jqXHR.message, "success");
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log(arguments);
            Swal.fire('Gagal', jqXHR.message, "error");
        });
    }

    function submit(checklist_kriteria_id) {
        var checklist_id = <?=json_encode($checklist_id)?>;
        var ket_auditee = document.getElementById("ket_auditee_".concat(checklist_kriteria_id)).value;
        var data_pendukung = document.getElementById("data_pendukung_".concat(checklist_kriteria_id)).value;
        var filename = data_pendukung.replace(/^.*\\/, "");

        $.ajax({
            type: 'POST',
            url: "/auditee/checklist/detail/".concat(checklist_id, "/s/"),
            data: {
                'id': checklist_kriteria_id,
                'ket_auditee': ket_auditee,
                'data_pendukung': filename,
            },
            success: function(response) {
                if (response.success === true) {
                    console.log(response);
                    Swal.fire('Sukses', response.message, "success");
                } else {
                    console.log(response);
                    Swal.fire('Gagal', response.message, "error");
                }
            },
        });
    }
</script>