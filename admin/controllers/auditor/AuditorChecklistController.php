<?php

namespace app\admin\controllers\auditor;

use app\admin\models\Ami;
use app\admin\models\Checklist;
use app\admin\models\ChecklistAuditor;
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
            'primary', 'secondary', 'danger', 'info', 'warning', 'success',
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

    public function detail(Request $request, Response $response, $param)
    {
        $checklist = Checklist::findOrFail($param);
        $current_auditor_user = App::$app->user->auditor();
        $checklist_has_kriterias = $current_auditor_user->checklist_has_kriterias(['checklist_id' => $checklist->id]);
        $auditors = $checklist->auditors();
        $colors = [
            'primary', 'secondary', 'danger', 'info', 'warning', 'success',
        ];
        $prev_year = (int)date('Y')-1;
        $prev_ami_periode = Ami::findOne(['tahun' => $prev_year]);
//        echo '<pre>';
//        var_dump($auditors);
//        echo '</pre>';
//        exit();

        App::setLayout('layout');
        return App::view('auditor/checklist/detail', [
            'checklist_id' => $param["id"],
            'checklist' => $checklist,
            'checklist_has_kriterias' => $checklist_has_kriterias,
            'auditors' => $auditors,
            'colors' => $colors,
            'current_auditor_id' => App::$app->user->auditor()->user_id,
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
}