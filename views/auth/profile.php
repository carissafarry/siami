<?php
/**
 * @var $this \app\includes\View
 * @var $users array
 */

use app\includes\App;

$this->title = 'Profile';
$this->breadcrumbs = 'Profile';
$this->header_title = $this->breadcrumbs;
?>

<div class="row my-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6">
                        <h6><span class="text-warning"><?= App::$app->user->nama ?></span></h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <form action="<?= APP_PATH ?>/profile" method="post">
                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            <div class="col-sm-6">
                                <h6 class="mb-0"><small>Role</small></h6>
                                <p><small><?= App::$app->user->role()->role ?></small></p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="mb-0"><small>Area</small></h6>
                                <p><small><?= App::$app->user->area()->nama ?></small></p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="mb-0"><small>Email</small></h6>
                                <p><small><?= App::$app->user->net_id ?></small></p>
                            </div>
                            <input type="hidden" name="id" value="<?= App::$app->user->id ?>">
                            <div class="form-group">
                                <label for="telp" class="form-control-label h6"><small>Telepon</small></label>
                                <input class="form-control" type="text" name="telp" value="<?= App::$app->user->telp ?>" id="example-tel-input">
                            </div>
                            <div class="form-group">
                                <label for="jabatan" class="form-control-label h6"><small>Jabatan</small></label>
                                <input class="form-control" type="text" name="jabatan" value="<?= App::$app->user->jabatan ?>" id="example-text-input">
                            </div>
                            <div class="form-group">
                                <label for="tahun" class="form-control-label h6"><small>Tahun</small></label>
                                <input class="form-control" type="text" name="tahun" value="<?= App::$app->user->tahun ?>" id="example-text-input">
                            </div>
                        </div>
                    </div>
                    <div class="row text-right">
                        <div class="div">
                            <button type="submit" class="btn bg-gradient-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
