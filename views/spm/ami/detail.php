<?php
/**
 * @var $this \app\includes\View
 * @var $ami \app\admin\models\Ami
 * @var $are_all_audited bool
 * @var $rule \app\admin\rules\spm\ami\AddJadwalRtm
 */

use app\includes\App;

$this->title = 'AMI | Detail';
$this->breadcrumbs = 'AMI / Detail';
$this->header_title = 'Detail AMI';
?>

<?php if ($are_all_audited && ((!isset($ami->rtm_mulai)) && (!isset($ami->rtm_selesai)))) : ?>
<div class="text-right">
    <button type="button" data-bs-toggle="modal" data-bs-target="#addRTM" class="btn bg-gradient-warning">Tambah Jadwal RTM</button>
</div>
<?php endif; ?>

<div class="row <?= $are_all_audited ? 'mb-4' : 'my-4' ?>">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Audit Mutu Internal Tahun <?= $ami->tahun ?></h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-sm-5 px-4">
                <div class="row mb-4">
                    <div class="col-lg-9 col-md-9 px-md-5">
                        <div class="row">
                            <div class="col-sm-6 col-4">
                                <h6 class="mb-0"><small>Kepala SPM</small></h6>
                                <p><small><?= $ami->spm()->user()->nama ?></small></p>
                            </div>
                            <div class="col-sm-6 col-4">
                                <h6 class="mb-0"><small>Periode</small></h6>
                                <p><small><?= $ami->tahun ?></small></p>
                            </div>
                            <div class="col-sm-6 col-4">
                                <h6 class="mb-0"><small>Jadwal Mulai Audit</small></h6>
                                <?php $audit_mulai = date_create($ami->audit_mulai); ?>
                                <p><small><?= date_format($audit_mulai, "l, j F Y") ?></small></p>
                            </div>
                            <div class="col-sm-6 col-12">
                                <h6 class="mb-0"><small>Jadwal Selesai Audit</small></h6>
                                <?php $audit_selesai = date_create($ami->audit_selesai); ?>
                                <p><small><?= date_format($audit_selesai, "l, j F Y") ?></small></p>
                            </div>
                            <?php if ((isset($ami->rtm_mulai)) && (isset($ami->rtm_selesai))): ?>
                                <div class="col-sm-6 col-12">
                                    <h6 class="mb-0"><small>Jadwal Mulai RTM</small></h6>
                                    <?php $rtm_mulai = date_create($ami->rtm_mulai); ?>
                                    <p><small><?= date_format($rtm_mulai, "l, j F Y") ?></small></p>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <h6 class="mb-0"><small>Jadwal Selesai RTM</small></h6>
                                    <?php $rtm_selesai = date_create($ami->rtm_selesai); ?>
                                    <p><small><?= date_format($rtm_selesai, "l, j F Y") ?></small></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row text-left">
                    <div class="div">
                        <a href="<?= APP_PATH ?>/spm/ami" type="button" class="btn btn-sm bg-gradient-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addRTM" tabindex="-1" role="dialog" aria-labelledby="tambahJadwalRTM" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRTMLabel">Tambah Jadwal RTM</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="addRTMForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rtm_mulai" class="col-form-label">Tanggal Mulai:</label>
                        <input type="date" name="rtm_mulai" class="form-control" id="rtm_mulai">
                    </div>
                    <div class="form-group">
                        <label for="rtm_selesai" class="col-form-label">Tanggal Selesai:</label>
                        <input type="date" name="rtm_selesai" class="form-control" id="rtm_selesai">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn bg-gradient-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var url = <?= json_encode(App::getRoute()) ?>

        $('.addRTMForm').on('submit', function(e) {
           e.preventDefault();
            $.post(url, {
                rtm_mulai: $(this).find('input[name=rtm_mulai]').val(),
                rtm_selesai: $(this).find('input[name=rtm_selesai]').val(),
            }).done(function(jqXHR) {
                Swal.fire('Sukses', jqXHR.message, "success");
                $('.swal2-confirm').on('click', function(e) {
                    e.preventDefault();
                    location.reload();
                });
            })
        });
    })
</script>
