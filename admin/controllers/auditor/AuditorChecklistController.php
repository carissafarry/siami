<?php

namespace app\admin\controllers\auditor;

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
    public function index(Request $request, Response $response)
    {
        $amis = Ami::findAll();
        $last_ami = Ami::findOne(['id' => Ami::getLastInsertedRow()->id]);
        $current_auditor_user = App::$app->user->auditor();
        $checklists = $current_auditor_user->checklists(['ami_id' => $last_ami->id]);
        $colors = [
            'primary', 'warning', 'info', 'danger', 'success',
        ];

        App::setLayout('layout');

        if ($request->isPost()) {
            $request = $request->getBody();

            //  Find checklist with given year
            $checklists = $current_auditor_user->checklists(['ami_id' => $request['ami_id']]);
            $requested_ami = Ami::findOne(['id' => $request['ami_id']]);

            return App::view('auditor/checklist/index', [
                'checklists' => $checklists,
                'amis' => $amis,
                'tahun' => $requested_ami->tahun,
                'colors' => $colors,
            ]);
        }

        return App::view('auditor/checklist/index', [
            'checklists' => $checklists,
            'amis' => $amis,
            'tahun' => $last_ami->tahun,
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
            'primary', 'warning', 'success', 'danger', 'success',
        ];

        //  Look for previous period checklist data
        $prev_period_ami = Ami::findOne(['tahun' => ($checklist->ami()->tahun - 1)]);
        $prev_period_checklist = false;
        $prev_checklist_has_kriterias = [];

        if ($prev_period_ami) {
            $prev_period_checklist = Checklist::findOne([
                'ami_id' => $prev_period_ami->id,
                'area_id' => $checklist->area_id,
            ]);
            $prev_checklist_has_kriterias = ChecklistHasKriteria::findAll('checklist_has_kriteria', ['checklist_id' => $prev_period_checklist->id], ChecklistHasKriteria::class);
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
        $checklist->loadData([
            'status_id' => 3
        ]);

        if ($checklist->update()) {
            App::$app->session->setFlash('success', 'Data Audit berhasiil disubmit!');
            $response->back();
        }
    }

    public function detail_checklist_has_kriteria(Request $request, Response $response, $param)
    {
        $checklist_has_kriteria = ChecklistHasKriteria::findOne([
            'id' => $param['id'],
            'checklist_id' => $param['checklist_id'],
        ]);
        $colors = [
            'primary', 'warning', 'info', 'danger', 'success',
        ];

        App::setLayout('layout');
        return App::view('auditor/checklist/detail_checklist_has_kriteria', [
            'checklist_has_kriteria' => $checklist_has_kriteria,
            'colors' => $colors,
        ]);
    }

    public function viewFile(Request $request, Response $response, $param)
    {
        $checklist_kriteria = ChecklistHasKriteria::findOrFail($param);
        $response->file($checklist_kriteria->data_pendukung);
    }
}