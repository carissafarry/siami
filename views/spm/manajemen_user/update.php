<?php
/**
 * @var $this \app\includes\View
 * @var $user \app\admin\models\auth\User
 * @var $roles array \app\admin\models\auth\Role
 * @var $areas array \app\admin\models\Area
 * @var $rule \app\admin\rules\spm\manajemen_user\UpdateUserRule
 */

use app\includes\App;

$this->title = 'Manajemen User | Edit';
$this->breadcrumbs = 'Manajemen User / Edit';
$this->header_title = 'Edit User';
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Edit User <span class="text-warning"><?= $user->nama ?></span></h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-0"><small>Email</small></h6>
                        <p><small><?= $user->net_id ?></small></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-0"><small>Nama</small></h6>
                        <p><small><?= $user->nama ?></small></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-0"><small>Status</small></h6>
                        <?php if ($user->status == 'active'): ?>
                            <p><small><span class="badge bg-gradient-success"><?= $user->status ?></span></small></p>
                        <?php else: ?>
                            <p><small><span class="badge bg-gradient-danger"><?= $user->status ?></span></small></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-0"><small>NIP</small></h6>
                        <p><small><?= $user->nip ?></small></p>
                    </div>
                </div>
                <form action="" method="post">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="area_id" class="h6 text-sm form-control-label">Area</label>
                                <select class="form-select" name="area_id" id="area_id">
                                    <option value="<?= $user->area_id ?>"><?= $user->area()->nama ?></option>
                                    <?php
                                    foreach ($areas as $area):
                                        if ($area->id != $user->area_id):
                                    ?>
                                        <option value="<?= $area->id ?>"><?= $area->nama ?></option>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jabatan" class="h6 text-sm form-control-label">Jabatan</label>
                                <input name="jabatan" class="form-control <?= $rule->hasError('jabatan') ? 'is-invalid' : '' ?>" type="text" value="<?= $user->jabatan ?>" id="jabatan">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('jabatan') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role_id" class="h6 text-sm form-control-label">Role</label>
                                <select class="form-select" name="role_id" id="role_id">
                                    <option value="<?= $user->role_id ?>"><?= $user->role()->role ?></option>
                                    <?php
                                    foreach ($roles as $role):
                                        if ($role->id != $user->role_id):
                                    ?>
                                        <option value="<?= $role->id ?>"><?= $role->role ?></option>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telp" class="h6 text-sm form-control-label">Telepon</label>
                                <input name="telp" class="form-control <?= $rule->hasError('telp') ? 'is-invalid' : '' ?>" type="text" value="<?= $user->telp ?>" id="telp">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('telp') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun" class="h6 text-sm form-control-label">Tahun</label>
                                <input name="tahun" class="form-control <?= $rule->hasError('tahun') ? 'is-invalid' : '' ?>" type="text" value="<?= $user->tahun ?>" id="tahun">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('tahun') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="/<?= strtolower(App::$app->user->role()->role) ?>/manajemen-user" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</a>
                        <button type="submit" class="btn btn-sm bg-gradient-warning">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
