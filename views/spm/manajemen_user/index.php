<?php
/**
 * @var $this \app\includes\View
 * @var $users array \app\admin\models\auth\User
 */

use app\includes\App;

$this->title = 'Manajemen User | Index';
$this->breadcrumbs = 'Manajemen User';
$this->header_title = $this->breadcrumbs;
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-sm-6 col-4">
                        <h6>Data User</h6>
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
                                Profil
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Jabatan
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Area
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                NIDN/NIP/NIDK
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Role
                            </th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                Aksi
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        foreach ($users as $user):
                        ?>
                            <tr class="text-sm">
                                <td class="center-table"> <?= $no ?> </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-xs"><?= $user->nama ?></h6>
                                            <p class="text-xs text-secondary mb-0"><?= $user->net_id ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="center-table"> <?= $user->jabatan ?> </td>
                                <td class="center-table"> <?= $user->area()->nama ?> <?= ($user->area()->is_prodi == 1) ? $user->area()->jurusan : '' ?> </td>
                                <td class="center-table"> <?= $user->nip ?> </td>
                                <td class="center-table"> <?= $user->role()->role ?> </td>
                                <td class="center-table align-content-center">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li class="inline-icon"><a href="<?= App::getRoute() ?>/detail/<?= $user->id ?>"><i class="fas fa-info-circle"></i></a></li>
                                        <li class="inline-icon"><a href="<?= App::getRoute() ?>/update/<?= $user->id ?>"><i class="fas fa-pen"></i></a></li>
                                        <li class="inline-icon">
                                            <form method="post" action="<?= App::getRoute() ?>/delete/<?= $user->id ?>" class="inline">
                                                <input type="hidden" name="delete_<?= $user->id ?>" value="<?= $user->id ?>">
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
