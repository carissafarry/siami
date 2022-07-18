<?php

namespace app\admin\controllers\auditor;

use app\admin\middleware\AuthMiddleware;
use app\admin\models\Ami;
use app\admin\models\Checklist;
use app\admin\models\ChecklistAuditor;
use app\admin\models\ChecklistHasKriteria;
use app\includes\App;
use app\includes\Controller;
use app\includes\Request;
use app\includes\Response;

class AuditorChecklistController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(
            new AuthMiddleware([
                'index',
                'update',
                'detail_checklist_has_kriteria',
            ])
        );
    }
    public function index(Request $request, Response $response, $param)
    {
        $last_ami = Ami::findOne(['id' => Ami::getLastInsertedRow()->id]);
        $tahun = (isset($param["tahun"])) ? $param["tahun"] : $last_ami->tahun;
        $ami = Ami::findOrFail(['tahun' => $tahun]);
        $ami_years = Ami::findAll(null, null, null, null, 'tahun');
        
        $current_auditor_user = App::$app->user->auditor();
        $checklists = $current_auditor_user->checklists(['ami_id' => $ami->id]);
        $colors = [
            'primary', 'warning', 'info', 'danger', 'warning', 'success',
        ];

        App::setLayout('layout');
        return App::view('auditor/checklist/index', [
            'checklists' => $checklists,
            'tahun' => $tahun,
            'ami_years' => $ami_years,
            'colors' => $colors,
        ]);
    }

    public function update(Request $request, Response $response, $param)
    {
        $checklist = Checklist::findOrFail($param);
        $current_auditor_user = App::$app->user->auditor();
        $checklist_has_kriterias = $current_auditor_user->checklist_has_kriterias(['checklist_id' => $checklist->id]);
        $auditors = $checklist->auditors();
        $colors = [
            'primary', 'warning', 'info', 'danger', 'warning', 'success',
        ];

        //  Look for previous period checklist data
        $prev_period_ami = Ami::findOne(['tahun' => ($checklist->ami()->tahun - 1)]);
        $prev_period_checklist = false;
        $prev_checklist_has_kriterias = [];
        $same_prev_checklist_has_kriterias = [];
        
        //  look for data with the same criteria as the previous year
        if ($prev_period_ami) {
            $prev_period_checklist = Checklist::findOne([
                'ami_id' => $prev_period_ami->id,
                'area_id' => $checklist->area_id,
            ]);

            if ($prev_period_checklist) {
                $prev_checklist_has_kriterias = ChecklistHasKriteria::findAll('checklist_has_kriteria', ['checklist_id' => $prev_period_checklist->id], ChecklistHasKriteria::class);
                foreach ($checklist_has_kriterias as $checklist_has_kriteria) {
                    foreach ($prev_checklist_has_kriterias as $prev_checklist_has_kriteria) {
                        if (preg_replace( "/\r|\n/", "", strtolower($checklist_has_kriteria->kriteria()->kriteria)) == preg_replace( "/\r|\n/", "", strtolower($prev_checklist_has_kriteria->kriteria()->kriteria))) {
                            $same_prev_checklist_has_kriterias[] = $prev_checklist_has_kriteria->kriteria()->kriteria;
                        }
                    }
                }
            }
        }
        
        App::setLayout('layout');
        return App::view('auditor/checklist/update', [
            'checklist_id' => $param["id"],
            'checklist' => $checklist,
            'checklist_has_kriterias' => $checklist_has_kriterias,
            'auditors' => $auditors,
            'current_auditor_id' => $current_auditor_user->user_id,
            'prev_checklist_has_kriterias' => $prev_checklist_has_kriterias,
            'prev_period_auditors' => $prev_period_checklist ? $prev_period_checklist->auditors() : null,
            'same_prev_checklist_has_kriterias' => $same_prev_checklist_has_kriterias,
            'colors' => $colors,
        ]);
    }

    public function saveChecklistKriteria(Request $request, Response $response, $param)
    {
        $request = $request->getBody();
        $checklist_auditor = ChecklistAuditor::findOne(['id' => $request['id']], 'checklist_auditor', ChecklistAuditor::class);

        $checklist_auditor->loadData($request);

        if ($checklist_auditor->update()) {
            $response->json([
                'success' => true,
                'message' => 'Keterangan Auditor berhasil diperbarui!',
                'param' => $param,
                'requests' => $request,
                'checklist_auditor' => $checklist_auditor,
            ]);
        } else {
            $response->json([
                'success' => false,
                'message' => 'Keterangan Auditor gagal diperbarui!',
                'param' => $param,
                'requests' => $request,
                'checklist_auditor' => $checklist_auditor,
            ]);
        }
    }

    public function submitAudit(Request $request, Response $response)
    {
        $request = $request->getBody();
        $checklist = Checklist::findOne(['id' => $request['checklist_id']]);
        $current_auditor_user = App::$app->user->auditor();
        $checklist_has_kriterias = $current_auditor_user->checklist_has_kriterias(['checklist_id' => $checklist->id]);

        $checklist->loadData([
            'status_id' => 3,
            'waktu_audit' => date_create(date(),timezone_open("Asia/Jakarta"))->format('d-m-Y H.i.s'),
        ]);

        foreach ($checklist_has_kriterias as $checklist_has_kriteria) {
            $checklist_score_auditors = ChecklistAuditor::findAll(null, ['checklist_kriteria_id' => $checklist_has_kriteria->id], ChecklistAuditor::class, null, 'nilai');
            if (max($checklist_score_auditors) < 4) {
                $checklist_has_kriteria->tidak_sesuai = 1;
            } else {
                $checklist_has_kriteria->tidak_sesuai = 0;
            }
            $checklist_has_kriteria->update();
        }

        if ($checklist->update()) {
            App::$app->session->setFlash('success', 'Data Audit berhasiil disubmit!');
        } else {
            App::$app->session->setFlash('failed', 'Data Audit gagal disubmit!');
        }
        $response->back();
    }

    public function detail_checklist_has_kriteria(Request $request, Response $response, $param)
    {
        $checklist_has_kriteria = ChecklistHasKriteria::findOne([
            'id' => $param['id'],
            'checklist_id' => $param['checklist_id'],
        ]);
        $checklist_auditors = $checklist_has_kriteria->checklist_auditors();
        $last_ami = Ami::findOne(['id' => Ami::getLastInsertedRow()->id]);
        $last_year_ami = $last_ami->tahun;
        $checklist_auditor = $checklist_has_kriteria->checklist_auditor(['auditor_id' => App::$app->user->auditor()->user_id]);
        $prev_checklist = Checklist::findOne(['ami_id' => $last_ami->id]);
        $colors = [
            'primary', 'warning', 'info', 'danger', 'success',
        ];

        //  Look for previous period checklist data
        $checklist = Checklist::findOrFail(['id' => $param['checklist_id']]);
        $prev_period_ami = Ami::findOne(['tahun' => ($checklist->ami()->tahun - 1)]);

        $prev_period_checklist = false;
        $is_used_in_prev_checklist_has_kriteria = false;
        $prev_checklist_has_kriteria = null;
        $prev_checklist_auditors = null;
        $tidak_sesuai = false;

        if ($prev_period_ami) {
            $prev_period_checklist = Checklist::findOne([
                'ami_id' => $prev_period_ami->id,
                'area_id' => $checklist->area_id,
            ]);

            if ($prev_period_checklist) {
                $prev_checklist_kriterias = $prev_period_checklist->pivot();
                foreach ($prev_checklist_kriterias as $prev_checklist_kriteria) {
                    if (preg_replace( "/\r|\n/", "", strtolower($checklist_has_kriteria->kriteria()->kriteria)) == preg_replace( "/\r|\n/", "", strtolower($prev_checklist_kriteria->kriteria()->kriteria))) {
                        $is_used_in_prev_checklist_has_kriteria = true;
                        $prev_checklist_has_kriteria = $prev_checklist_kriteria;
                    }
                }
            }

            if ($prev_checklist_has_kriteria) {
                $prev_checklist_auditors = $prev_checklist_has_kriteria->checklist_auditors();
            }

//            if ($prev_period_checklist) {
//                $prev_checklist_has_kriterias = ChecklistHasKriteria::findAll('checklist_has_kriteria', ['checklist_id' => $prev_period_checklist->id], ChecklistHasKriteria::class);
//                foreach ($prev_checklist_has_kriterias as $prev_checklist_has_kriteria) {
//                    $prev_kriterias[] = preg_replace( "/\r|\n/", "", strtolower(Kriteria::findOne(['id' => $prev_checklist_has_kriteria_id], null, null, null, 'kriteria')));
//                }
//                if (in_array(preg_replace("/\r|\n/", '', strtolower($checklist_has_kriteria->kriteria()->kriteria)), $prev_kriterias)) {
//                    $is_used_in_prev_checklist_period = true;
//                }
//            }
        }

        App::setLayout('layout');
        return App::view('auditor/checklist/detail_checklist_has_kriteria', [
            'checklist_id' => $param['checklist_id'],
            'checklist_has_kriteria' => $checklist_has_kriteria,
            'checklist_auditors' => $checklist_auditors,
            'checklist_auditor' => $checklist_auditor,
            'last_year_ami' => $last_year_ami,
            'prev_checklist' => $prev_checklist,
            'is_used_in_prev_checklist_has_kriteria' => $is_used_in_prev_checklist_has_kriteria,
            'prev_checklist_has_kriteria' => $prev_checklist_has_kriteria,
            'prev_checklist_auditors' => $prev_checklist_auditors,
            'prev_ami_period' => $prev_period_ami,
            'colors' => $colors,
        ]);
    }

    public function viewFile(Request $request, Response $response, $param)
    {
        $checklist_kriteria = ChecklistHasKriteria::findOrFail($param);
        $response->file($checklist_kriteria->data_pendukung);
    }

    public function saveTinjauanEfektivitas(Request $request, Response $response, $param)
    {
        $request = $request->getBody();
        $checklist_has_kriteria = ChecklistHasKriteria::findOne(['id' => $request['id']]);
        $checklist_has_kriteria->loadData($request);

        if ($checklist_has_kriteria->update()) {
            $response->json([
                'success' => true,
                'message' => 'Data Tinjauan Efektivitas Tindakan Koreksi berhasil diperbarui!',
                'param' => $param,
                'requests' => $request,
            ]);
        } else {
            $response->json([
                'success' => false,
                'message' => 'Data Tinjauan Efektivitas Tindakan Koreksi gagal diperbarui!',
                'param' => $param,
                'requests' => $request,
            ]);
        }
    }

    public function saveAudit(Request $request, Response $response, $param)
    {
        $request = $request->getBody();
        $checklist_auditor = ChecklistAuditor::findOne(['id' => $request['checklist_auditor_id']]);

        if (isset($request['ket_auditor'])) {
            $request['ket_auditor'] = htmlentities($request['ket_auditor']);
        }
        $checklist_auditor->loadData($request);

        if ($checklist_auditor->update()) {
            App::$app->session->setFlash('success', 'Data Audit berhasil disimpan!');
            $response->back();
        }
    }
}