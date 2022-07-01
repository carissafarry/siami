<?php
/**
 * @var $this \app\includes\View
 * @var $areas array \app\admin\models\Area
 * @var $rule \app\admin\rules\spm\manajemen_user\AddUserRule
 */

use app\includes\App;

$this->title = 'Manajemen User | Add';
$this->breadcrumbs = 'Manajemen User / Add';
$this->header_title = 'Tambah User';
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-body px-sm-5 px-4">
                <form action="/spm/manajemen-user/add" method="post">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="net_id" class="h6 text-sm form-control-label">Email / Net ID</label>
                                <input name="net_id" class="form-control <?= $rule->hasError('net_id') ? 'is-invalid' : '' ?>" type="text" id="net_id">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('net_id') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="area_id" class="h6 text-sm form-control-label">Area</label>
                                <select class="form-select" name="area_id" id="area_id">
                                    <?php foreach ($areas as $area): ?>
                                        <option value="<?= $area->id ?>"><?= $area->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jabatan" class="h6 text-sm form-control-label">Jabatan</label>
                                <input name="jabatan" class="form-control <?= $rule->hasError('jabatan') ? 'is-invalid' : '' ?>" type="text" id="jabatan">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('jabatan') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role_id" class="h6 text-sm form-control-label">Role</label>
                                <select class="form-select" name="role_id" id="role_id">
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?= $role->id ?>"><?= $role->role ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telp" class="h6 text-sm form-control-label">Telepon</label>
                                <input name="telp" class="form-control <?= $rule->hasError('telp') ? 'is-invalid' : '' ?>" type="text" id="telp">
                                <div class="invalid-feedback">
                                    <?= $rule->getFirstError('telp') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun" class="h6 text-sm form-control-label">Tahun</label>
                                <input name="tahun" class="form-control <?= $rule->hasError('tahun') ? 'is-invalid' : '' ?>" type="text" id="tahun">
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
