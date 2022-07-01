<?php

namespace app\admin\controllers\auditee;

use app\admin\models\Ami;
use app\admin\models\Checklist;
use app\admin\models\ChecklistHasKriteria;
use app\includes\App;
use app\includes\Controller;
use app\includes\Request;
use app\includes\Response;

class AuditeeChecklistController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $amis = Ami::findAll();
        $last_ami = Ami::findOne(['id' => Ami::getLastInsertedRow()->id]);
        $current_auditee_user = App::$app->user->auditee();
        $checklists = Checklist::findAll('checklist', [
            'ami_id' => $last_ami->id,
            'auditee_id' => $current_auditee_user->user_id,
        ]);
        $colors = [
            'primary', 'secondary', 'danger', 'info', 'warning', 'success',
        ];

        App::setLayout('layout');

        if ($request->isPost()) {
            $request = $request->getBody();

            //  Find checklist with given year
            $checklists = Checklist::findAll('checklist', [
                'ami_id' => $request['ami_id'],
                'auditee_id' => $current_auditee_user->user_id,
            ]);
            $requested_ami = Ami::findOne(['id' => $request['ami_id']]);

            return App::view('auditee/checklist/index', [
                'checklists' => $checklists,
                'amis' => $amis,
                'tahun' => $requested_ami->tahun,
                'colors' => $colors,
            ]);
        }

        return App::view('auditee/checklist/index', [
            'checklists' => $checklists,
            'amis' => $amis,
            'tahun' => $last_ami->tahun,
            'colors' => $colors,
        ]);
    }

    public function update(Request $request, Response $response, $param)
    {
        $checklist = Checklist::findOrFail($param);
        $kriterias = $checklist->kriterias();
        $auditors = $checklist->auditors();
        $checklist_has_kriterias = $checklist->pivot();
        $colors = [
            'primary', 'secondary', 'danger', 'info', 'warning', 'success',
        ];

        App::setLayout('layout');
        return App::view('auditee/checklist/update', [
            'checklist_id' => $param["id"],
            'checklist' => $checklist,
            'checklist_has_kriterias' => $checklist_has_kriterias,
            'auditors' => $auditors,
            'colors' => $colors,
        ]);
    }

    public function saveChecklistKriteria(Request $request, Response $response, $param)
    {
        $request = $request->getBody(null, 'contents/storage/data_pendukung');
        $checklist_kriteria = ChecklistHasKriteria::findOne(['id' => $request['id']], 'CHECKLIST_HAS_KRITERIA', ChecklistHasKriteria::class);

        if (($checklist_kriteria->data_pendukung != '') && isset($request['data_pendukung']) && file_exists(APP_ROOT . "/" . $checklist_kriteria->data_pendukung)) {
            unlink(APP_ROOT . "/" . $checklist_kriteria->data_pendukung);
        }

        $checklist_kriteria->loadData($request);

        if ($checklist_kriteria->update()) {
            $response->json([
                'success' => true,
                'message' => 'Keterangan Auditee berhasil diperbarui!',
                'param' => $param,
                'requests' => $request,
                'checklist_kriteria' => $checklist_kriteria,
            ]);
        } else {
            $response->json([
                'success' => false,
                'message' => 'Keterangan Auditee gagal diperbarui!',
                'param' => $param,
                'requests' => $request,
                'checklist_kriteria' => $checklist_kriteria,
            ]);
        }
    }

    public function viewFile(Request $request, Response $response, $param)
    {
        $checklist_kriteria = ChecklistHasKriteria::findOrFail($param);
        $response->file($checklist_kriteria->data_pendukung);
    }

    public function detail_checklist_has_kriteria(Request $request, Response $response, $param)
    {
        echo '<pre>';
        var_dump($param);
        echo '</pre>';
        exit();

    }
}