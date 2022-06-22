<?php
/**
 * @var $this \app\includes\View
 * @var $amis array \app\admin\models\Ami
 */

use app\includes\App;

$this->title = 'AMI | Index';
$this->breadcrumbs = 'AMI';
$this->header_title = 'Audit Mutu Internal';
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-sm-6 col-4">
                        <h6>Data AMI</h6>
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
                                Periode
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Kepala SPM
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Jadwal
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Satus Tindak Lanjut
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Aksi
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $no = 1;
                            foreach ($amis as $ami):
                                $user_spm = $ami->spm()->user();
                        ?>
                            <tr class="text-sm">
                                <td class="center-table"> <?= $no ?> </td>
                                <td class="center-table"> <?= $ami->tahun ?> </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="/contents/assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-xs">
                                                <a href="/spm/manajemen-user/detail/<?= $user_spm->id ?>">
                                                    <?= $user_spm->nama ?>
                                                </a>
                                            </h6>
                                            <p class="text-xs text-secondary mb-0"><?= $user_spm->net_id ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="center-table"> <?= date('d M Y', strtotime($ami->jadwal_mulai)) ?> - <?= date('d M Y', strtotime($ami->jadwal_selesai)) ?> </td>
                                <td class="center-table">
                                    <div class="form-check form-switch">
                                        <input name="is_tindak_lanjut" class="form-check-input" type="checkbox" id="is_tindak_lanjut" <?= ($ami->is_tindak_lanjut == 1) ? 'checked' : '' ?> disabled>
                                    </div>
                                </td>
                                <td class="center-table align-content-center">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li class="inline-icon"><a href="<?= App::getRoute() ?>/detail/<?= $ami->id ?>"><i class="fas fa-info-circle"></i></a></li>
                                        <li class="inline-icon"><a href="<?= App::getRoute() ?>/update/<?= $ami->id ?>"><i class="fas fa-pen"></i></a></li>
                                        <li class="inline-icon">
                                            <form method="post" action="<?= App::getRoute() ?>/delete/<?= $ami->id ?>" class="inline">
                                                <input type="hidden" name="delete_<?= $ami->id ?>" value="<?= $ami->id ?>">
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
