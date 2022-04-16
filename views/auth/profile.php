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
                    <div class="col-lg-6 col-7">
                        <h6><?= App::$app->user->nama ?></h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <form>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 text-center">
                            <a href="javascript:;" class="avatar avatar-xxl rounded-circle">
                                <img alt="Image placeholder" src="/contents/assets/img/team-4.jpg">
                            </a>
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <div class="form-group">
                                <label for="example-email-input" class="form-control-label h6"><small>Email</small></label>
                                <input class="form-control" type="email" value="<?= App::$app->user->net_id ?>" id="example-email-input">
                            </div>
                            <div class="form-group">
                                <label for="example-password-input" class="form-control-label h6"><small>Password</small></label>
                                <input class="form-control" type="password" value="password" id="example-password-input">
                            </div>
                            <div class="form-group">
                                <label for="example-tel-input" class="form-control-label h6"><small>Phone</small></label>
                                <input class="form-control" type="tel" value="<?= App::$app->user->telp ?>" id="example-tel-input">
                            </div>
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label h6"><small>Jabatan</small></label>
                                <input class="form-control" type="text" value="<?= App::$app->user->jabatan ?>" id="example-text-input">
                            </div>
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label h6"><small>Periode</small></label>
                                <input class="form-control" type="text" value="<?= App::$app->user->periode ?>" id="example-text-input">
                            </div>
                        </div>
                    </div>
                    <div class="row text-right">
                        <div class="div">
                            <button type="button" class="btn bg-gradient-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
