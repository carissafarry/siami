<?php
/**
 * @var $this \app\includes\View
 * @var $tahun int
 * @var $statuses \app\admin\models\Status
 * @var $checklist_statuses \app\admin\models\Checklist ->status
 * @var $checklist_status_counts array
 * @var $jumlah_spm int
 * @var $jumlah_auditor int
 * @var $jumlah_auditee int
 * @var $ami \app\admin\models\Ami
 */

use app\includes\App;

$this->title = 'Dashboard';
$this->breadcrumbs = 'Dashboard';
$this->header_title = $this->breadcrumbs;
$this->is_dashboard = true;
$component = \app\includes\Component::init()
?>

<?php if (App::$app->user->role()->role == 'SPM'): ?>
    <div class="row mb-4">
        <h6>Checklist <?= $tahun ?></h6>
        <?php foreach ($statuses as $status):
            $icon = '<i class="fas fa-spinner"></i>';
            if ($status->id == 1) {  // in progress
                $icon = '<i class="fas fa-spinner"></i>';
            } elseif ($status->id == 2) {  // submitted
                $icon = '<i class="fas fa-paper-plane"></i>';
            } elseif ($status->id == 3) {  // auditted
                $icon = '<i class="fas fa-tasks"></i>';
            } elseif ($status->id == 5) {  // rtm submitted
                $icon = '<i class="fas fa-clipboard-check"></i>';
            }
        ?>
            <?php if (!empty($checklist_statuses) && isset($checklist_status_counts[$status->id])): ?>
                <?= $component->countData($status->status, $checklist_status_counts[$status->id], $icon) ?>
            <?php else: ?>
                <?= $component->countData($status->status, 0, $icon) ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (App::$app->user->role()->role == 'SPM'): ?>
    <div class="row mb-4">
        <h6>Jumlah User <?= $tahun ?></h6>
        <?= $component->countData('SPM', $jumlah_spm, '<i class="fas fa-solid fa-user-tie"></i>') ?>
        <?= $component->countData('Auditor', $jumlah_auditor, '<i class="fas fa-solid fa-user-check"></i>') ?>
        <?= $component->countData('Auditee', $jumlah_auditee, '<i class="fas fa-solid fa-user"></i>') ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-5">
        <div class="">
            <div class="card h-100 p-3">
                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('/contents/assets/img/sea.jpg');">
                    <span class="mask bg-gradient-dark"></span>
                    <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                        <h5 class="text-white font-weight-bolder mb-4 pt-2">Dokumen Sistem Penjaminan Mutu Internal (SPMI) PENS</h5>
                        <p class="text-white">Dokumen Sistem Penjaminan Mutu Internal (SPMI) PENS meliputi...</p>
                        <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="http://pjm.pens.ac.id/dokumen-spmi/">
                            Read More
                            <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex">
                    <div class="align-self-center" style="padding-right: 1rem;">
                        <i class="ni ni-notification-70"></i>
                    </div>
                    <h6>Jadwal AMI <span class="text-warning"><?= $tahun ?></span></h6>
                </div>
                <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="ni ni-bell-55 text-success text-gradient"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Mulai Audit</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0"><?= $ami->audit_mulai ?></p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="ni ni-html5 text-danger text-gradient"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Selesai Audit</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0"><?= $ami->audit_selesai ?></p>
                            </div>
                        </div>
                        <?php if ($ami->rtm_mulai && $ami->rtm_selesai): ?>
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="ni ni-cart text-info text-gradient"></i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">Mulai Rapat Tinjauan Manajemen</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0"><?= $ami->rtm_mulai ?></p>
                                </div>
                            </div>
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="ni ni-credit-card text-warning text-gradient"></i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">Selesai Rapat Tinjauan Manajemen</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0"><?= $ami->rtm_selesai ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--    <div class="col-lg-7">-->
<!--        <div class="card">-->
<!--            <div class="card-header pb-0">-->
<!--                <h6>Ketidaksesuaian (KTS) Per Tahun</h6>-->
<!--            </div>-->
<!--            <div class="card-body p-3">-->
<!--                <div id="newHosting" style="margin-right: 1vw;"></div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>

<div class="row my-4">
    <?php
//    require  APP_ROOT . '/views/components/table/table1.php';
//    require  APP_ROOT . '/views/components/timeline/horizontal.php';
    ?>
</div>

<script type="application/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        //var dataNewHosting = <?php //echo json_encode($dataNewHosting); ?>//;
        const chart = Highcharts.chart('newHosting', {
            chart: {
                type: 'spline'
            },
            title: null,
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ]
                // categories: axis
            },
            yAxis: {
                title: {
                    text: 'Jumlah Permohonan'
                },
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            series: [{
                name: 'Hosting Baru',
                marker: {
                    symbol: 'square'
                },
                // data: dataNewHosting
                data: [5, 7, 3]
                // data: jumlah
            }]
        });
    });
</script>
