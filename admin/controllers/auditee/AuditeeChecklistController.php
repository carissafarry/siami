<?php

namespace app\admin\controllers\auditee;

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
        $current_auditee_user_id = App::$app->user->auditee()->user_id;
        $checklists = Checklist::findAll('checklist', ['auditee_id' => $current_auditee_user_id]);
        $colors = [
            'primary', 'secondary', 'danger', 'info', 'warning', 'success',
        ];

        App::setLayout('layout');
        return App::view('auditee/checklist/index', [
            'checklists' => $checklists,
            'colors' => $colors,
        ]);
    }

    public function detail(Request $request, Response $response, $param)
    {
        $checklist = Checklist::findOrFail($param);
        $kriterias = $checklist->kriterias();
        $auditors = $checklist->auditors();
        $checklist_has_kriterias = $checklist->pivot();
        $colors = [
            'primary', 'secondary', 'danger', 'info', 'warning', 'success',
        ];

        App::setLayout('layout');
        return App::view('auditee/checklist/detail', [
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

    }
}