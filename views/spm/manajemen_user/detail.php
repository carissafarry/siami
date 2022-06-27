<?php
/**
 * @var $this \app\includes\View
 * @var $user \app\admin\models\auth\User
 */

use app\includes\App;

$this->title = 'Manajemen User | Detail';
$this->breadcrumbs = 'Manajemen User / Detail';
$this->header_title = 'Detail User';
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6><?= $user->nama ?></h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <div class="row mb-4">
                    <div class="col-lg col-md mb-4">
                        <div class="row d-flex justify-content-center text-center">
                            <a href="javascript:;" class="avatar avatar-xxl rounded-circle">
                                <img alt="Image placeholder" src="/contents/assets/img/team-4.jpg">
                            </a>
                            <div class="div">
                                <span class="badge badge-sm bg-gradient-dark"><?= $user->jabatan ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block vr p-0" style="width: 1px"></div>
                    <div class="col-lg-9 col-md-9 px-md-5">
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <h6 class="mb-0"><small>Email</small></h6>
                                <p><small><?= $user->net_id ?></small></p>
                            </div>
                            <div class="col-sm-6 col-4">
                                <h6 class="mb-0"><small>Nama</small></h6>
                                <p><small><?= $user->nama ?></small></p>
                            </div>
                            <div class="col-sm-6 col-12">
                                <h6 class="mb-0"><small>Status</small></h6>
                                <p><small><?= $user->status ?></small></p>
                            </div>
                            <div class="col-sm-6 col-12">
                                <h6 class="mb-0"><small>NIP</small></h6>
                                <p><small><?= $user->nip ?></small></p>
                            </div>
                            <div class="col-sm-6 col-12">
                                <h6 class="mb-0"><small>Area</small></h6>
                                <p><small><?= $user->area()->nama ?></small></p>
                            </div>
                            <div class="col-sm-6 col-12">
                                <h6 class="mb-0"><small>Jabatan</small></h6>
                                <p><small><?= $user->jabatan ?></small></p>
                            </div>
                            <div class="col-sm-6 col-12">
                                <h6 class="mb-0"><small>Role</small></h6>
                                <p><small><?= $user->role()->role ?></small></p>
                            </div>
                            <div class="col-sm-6 col-12">
                                <h6 class="mb-0"><small>Telepon</small></h6>
                                <p><small><?= $user->telp ?></small></p>
                            </div>
                            <div class="col-sm-6 col-12">
                                <h6 class="mb-0"><small>Tahun</small></h6>
                                <p><small><?= $user->tahun ?></small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-left">
                    <div class="div">
                        <a href="/<?= strtolower(App::$app->user->role()->role) ?>/manajemen-user" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
