<?php
/**
 * @var $this \app\includes\View
 * @var $checklist \app\admin\models\Checklist
 * @var $checklist_has_kriterias array \app\admin\models\ChecklistHasKriteria
 * @var $auditors array \app\admin\models\Auditor
 * @var $checklist_id int
 */

use app\includes\App;

$this->title = 'Checklist | Detail';
$this->breadcrumbs = 'Checklist / Detail';
$this->header_title = 'Detail Checklist';
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
                        <h6 class="mb-0"><small>ID Checklist</small></h6>
                        <p><small><?= $checklist->id ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>No Revisi</small></h6>
                        <p><small><?= $checklist->no_revisi ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Tanggal Terbit</small></h6>
                        <p><small><?= $checklist->tgl_terbit ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Area</small></h6>
                        <p><small><?= $checklist->area()->nama ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>No Identifikasi</small></h6>
                        <p><small><?= $checklist->no_identifikasi ?></small></p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <h6 class="mb-0"><small>Auditee</small></h6>
                        <p><small><?= $checklist->auditee()->user()->nama ?></small></p>
                    </div>
                </div>
                <div class="row">
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
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>Auditee Pengganti</small></h6>
                        <p><small><?= $checklist->no_revisi ?></small></p>
                    </div>
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>Status</small></h6>
                        <p><small><?= $checklist->tgl_terbit ?></small></p>
                    </div>
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
                    <table id="table_id" class="table align-items-center mb-0">
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
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Aksi
                            </th>
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
                                <td class="center-table"> <?= $no ?> </td>
                                <td class="center-table"> <?= $kriteria->kriteria ?> </td>
                                <td class="center-table"> <?= $kriteria->catatan ?> </td>
                                <td class="center-table"> <?= $kriteria->ket_nilai ?> </td>
                                <td class="center-table">
                                    <textarea class="form-control ket_auditee" name="ket_auditee_<?= $checklist_kriteria->id ?>" id="ket_auditee_<?= $checklist_kriteria->id ?>" rows="4"><?= $checklist_kriteria->ket_auditee ?></textarea>
                                </td>
                                <td class="center-table">
                                    <a href="/auditee/checklist/view/<?= $checklist_kriteria->id ?>" target="__blank" style="color: #d0261f; padding-inline: 0.5rem;">
                                        <i class="fas fa-file"></i>
                                    </a>
                                    <input type="file" name="data_pendukung_<?= $checklist_kriteria->id ?>" id="data_pendukung_<?= $checklist_kriteria->id ?>">
                                </td>
                                <td class="center-table align-content-center">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li class="inline-icon"><a href="<?= App::getRoute() ?>/edit/<?= $checklist_kriteria->id ?>"><i class="fas fa-pen"></i></a></li>
                                        <li class="inline-icon">
                                            <button type="submit" value="<?= $checklist_kriteria->id ?>" class="btn-sm bg-transparent border-0 p-0 submitButton">
                                                <i class="fas fa-save"></i>
                                            </button>
                                        </li>
                                        <li class="inline-icon">
                                            <button type="submit" class="btn-sm bg-transparent border-0 p-0" onclick="submit(<?= json_encode($checklist_kriteria->id) ?>)">
                                                <i class="fas fa-save"></i>
                                            </button>
                                        </li>
                                        <li class="inline-icon"><a href="<?= App::getRoute() ?>/i/<?= $checklist_kriteria->id ?>"><i class="fas fa-info-circle"></i></a></li>
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
<div class="row text-left">
    <div class="div">
        <a href="/<?= strtolower(App::$app->user->role()->role) ?>/checklist" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</a>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.submitButton').click(function () {
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
                url: "/auditee/checklist/detail/".concat(checklist_id, "/s/"),
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