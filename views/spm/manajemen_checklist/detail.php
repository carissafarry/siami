<?php
/**
 * @var $this \app\includes\View
 * @var $checklist \app\admin\models\Checklist
 * @var $auditors array \app\admin\models\Auditor
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
                        <h6>Checklist</h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <div class="row mb-4">
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>AMI</small></h6>
                        <p><small><?= $checklist->ami()->tahun ?></small></p>
                    </div>
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>Status Checklist</small></h6>
                        <p><small><?= $checklist->status()->status ?></small></p>
                    </div>
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>Tanggal Terbit</small></h6>
                        <p><small><?= $checklist->tgl_terbit ?></small></p>
                    </div>
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>Nomor Identifikasi</small></h6>
                        <p><small><?= $checklist->no_identifikasi ?></small></p>
                    </div>
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>Nomor Revisi</small></h6>
                        <p><small><?= $checklist->no_revisi ?></small></p>
                    </div>
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>Area</small></h6>
                        <p><small><?= $checklist->area()->nama ?></small></p>
                    </div>
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>Auditee</small></h6>
                        <p><small><?= $checklist->auditee()->user()->nama ?> - <?= $checklist->auditee()->user()->net_id ?></small></p>
                    </div>
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>Auditee Pengganti</small></h6>
                        <?php if ($checklist->auditee2()) : ?>
                            <p><small><?= $checklist->auditee2()->user()->nama ?: '' ?></small></p>
                        <?php else: ?>
                            <p><small>-</small></p>
                        <?php endif; ?>
                    </div>
                    <?php
                    $no_auditor=1;
                    foreach ($auditors as $auditor):
                        $user_auditor = $auditor->user();
                    ?>
                        <div class="col-sm-6 col-12">
                            <h6 class="mb-0"><small>Auditor <?= $no_auditor ?></small></h6>
                            <p><small><?= $user_auditor->nama ?> - <?= $user_auditor->net_id ?></small></p>
                        </div>
                    <?php
                    $no_auditor++;
                    endforeach;
                    ?>
                    <?php if (count($auditors) < 3): ?>
                        <div class="col-sm-6 col-12">
                            <h6 class="mb-0"><small>Auditor 3</small></h6>
                            <p><small>-</small></p>
                        </div>
                    <?php endif; ?>
                    <div class="col-sm-6 col-12">
                        <h6 class="mb-0"><small>Status</small></h6>
                        <p><small><?= $checklist->status ?></small></p>
                    </div>
                </div>
                <div class="row text-left">
                    <div class="div">
                        <a href="/<?= strtolower(App::$app->user->role()->role) ?>/manajemen-checklist" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
