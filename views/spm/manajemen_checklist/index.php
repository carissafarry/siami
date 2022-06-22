<?php
/**
 * @var $this \app\includes\View
 * @var $checklists array \app\admin\models\Checklist
 * @var $amis array \app\admin\models\Ami
 * @var $colors array
 * @var $tahun string
 */

use app\includes\App;

$this->title = 'Manajemen Checklist | Index';
$this->breadcrumbs = 'Manajemen Checklist';
$this->header_title = $this->breadcrumbs;
?>

<div class="row">
    <div class="col-lg-2 col-sm-2 col-md-2">
        <form action="<?= App::getRoute() ?>" method="post" id="form_ami_id">
            <div class="form-group">
                <select class="form-select" name="ami_id" id="ami_id" onchange="submitAmiId()" style="outline: none;">
                <?php
                    foreach ($amis as $ami):
                        if ($ami->tahun == $tahun):
                ?>
                            <option value="<?= $ami->id ?>"><?= $ami->tahun ?></option>
                <?php
                        endif;
                    endforeach;
                ?>
                <?php
                    foreach ($amis as $ami):
                        if ($ami->tahun != $tahun):
                ?>
                            <option value="<?= $ami->id ?>"><?= $ami->tahun ?></option>
                <?php
                        endif;
                    endforeach;
                ?>
                </select>
            </div>
        </form>
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
                    <div class="col-sm-6 col-8">
                        <a href="<?= App::getRoute() ?>/add" type="button" class="btn btn-md bg-gradient-default" style="float: right; margin-left: 1rem;"><i class="fas fa-plus"></i></a>
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
                                Auditee
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
                                <td class="center-table"> <?= $checklist->area()->nama ?> </td>
                                <td class="center-table"> <?= $checklist->auditee()->user()->nama ?> </td>
                                <td><span class="badge bg-gradient-<?= $colors[($checklist->status_id - 1) % count($colors)] ?>"><?= $checklist->status()->status ?></span></td>
                                <td class="center-table align-content-center">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li class="inline-icon"><a href="<?= App::getRoute() ?>/detail/<?= $checklist->id ?>"><i class="fas fa-info-circle"></i></a></li>
                                        <li class="inline-icon"><a href="<?= App::getRoute() ?>/update/<?= $checklist->id ?>"><i class="fas fa-pen"></i></a></li>
                                        <li class="inline-icon">
                                            <form method="post" action="<?= App::getRoute() ?>/delete/<?= $checklist->id ?>" class="inline">
                                                <input type="hidden" name="delete_<?= $checklist->id ?>" value="<?= $checklist->id ?>">
                                                <button type="submit" class="btn-sm bg-transparent border-0 p-0">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </li>
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
        form.submit();
    }
</script>