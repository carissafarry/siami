<?php
/**
 * @var $this \app\includes\View
 * @var $checklists array \app\admin\models\Checklist
 * @var $tahun string
 * @var $ami_years array \app\admin\models\Ami tahun
 * @var $colors array
 */

use app\includes\App;

$this->title = 'Checklist | Index';
$this->breadcrumbs = 'Checklist';
$this->header_title = $this->breadcrumbs;
?>

<div class="row mb-4">
    <div class="col-lg-2 col-sm-2 col-md-2">
        <select class="form-select" name="tahun" id="tahun" style="outline: none;" onchange="window.location = this.value;">
            <?php foreach ($ami_years as $year): ?>
                <option value="<?= APP_PATH ?>/auditee/checklist/<?= $year ?>" <?= ($year == $tahun) ? 'selected' : ''?>><?= $year ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-sm-6 col-4">
                        <h6>Data Checklist</h6>
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
                                Tgl Terbit
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                No Identifikasi
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                No Revisi
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Area
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Status
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Aksi
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $no = 1;
                            foreach ($checklists as $checklist):
                        ?>
                            <tr class="text-sm">
                                <td class="center-table"> <?= $no ?> </td>
                                <td class="center-table"> <?= $checklist->tgl_terbit ?> </td>
                                <td class="center-table"> <?= $checklist->no_identifikasi ?> </td>
                                <td class="center-table"> <?= $checklist->no_revisi ?> </td>
                                <td class="center-table"> <?= $checklist->area()->nama ?>  <?= $checklist->area()->is_prodi == 1 ? $checklist->area()->jurusan : ''?></td>
                                <td><span class="badge bg-gradient-<?= $colors[($checklist->status_id - 1) % count($colors)] ?>"><?= $checklist->status()->status ?></span></td>
                                <td class="center-table align-content-center">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li class="inline-icon"><a href="<?= APP_PATH ?>/auditor/checklist/update/<?= $checklist->id ?>"><i class="fas fa-pen"></i></a></li>
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

<script type="text/javascript">
    function submitAmiId() {
        var form = $('#form_ami_id');
        // console.log(form);
        form.submit();
    }
</script>