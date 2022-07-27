<?php

namespace app\admin\controllers\auditee;

use app\admin\middleware\AuthMiddleware;
use app\admin\models\Ami;
use app\admin\models\Checklist;
use app\admin\models\ChecklistHasKriteria;
use app\includes\App;
use app\includes\Controller;
use app\includes\Request;
use app\includes\Response;

class AuditeeChecklistController extends Controller
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

        $current_auditee_user = App::$app->user->auditee();
        $checklists = Checklist::findAll('checklist', [
            'ami_id' => $ami->id,
            'auditee_id' => $current_auditee_user->user_id,
        ]);
        $colors = [
            'primary', 'secondary', 'danger', 'info', 'warning', 'success',
        ];

        App::setLayout('layout');
        return App::view('auditee/checklist/index', [
            'checklists' => $checklists,
            'ami_years' => $ami_years,
            'tahun' => $tahun,
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
            'primary', 'secondary', 'info', 'primary', 'warning', 'success',
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
        $checklist = Checklist::findOrFail(['id' => $param['checklist_id']]);
        $checklist_has_kriteria = ChecklistHasKriteria::findOne([
            'id' => $param['id'],
            'checklist_id' => $param['checklist_id'],
        ]);
        $checklist_auditors = $checklist_has_kriteria->checklist_auditors();
        $last_year_ami = Ami::findOne(['id' => Ami::getLastInsertedRow()->id])->tahun;
        $checklist_auditor_nilais = $checklist_has_kriteria->checklist_auditors([], 'nilai');
        $checklist_auditor = $checklist_has_kriteria->checklist_auditor();
        $colors = [
            'primary', 'warning', 'info', 'danger', 'success',
        ];

        if ($request->isPost()) {
            $request = $request->getBody();
            $checklist_has_kriteria->loadData($request);
            if ($checklist_has_kriteria->update()) {
                App::$app->session->setFlash('success', 'Data Rencana Tindakan Koreksi berhasil disimpan!');
                $response->back();
            }
        }

        App::setLayout('layout');
        return App::view('auditee/checklist/detail_checklist_has_kriteria', [
            'checklist' => $checklist,
            'checklist_has_kriteria' => $checklist_has_kriteria,
            'checklist_auditors' => $checklist_auditors,
            'last_year_ami' => $last_year_ami,
            'checklist_auditor_nilais' => $checklist_auditor_nilais,
            'checklist_auditor' => $checklist_auditor,
            'colors' => $colors,
        ]);
    }

    public function submitTindakLanjut(Request $request, Response $response, $param)
    {
        $request = $request->getBody();
        $checklist = Checklist::findOne(['id' => $request['checklist_id']]);

        $checklist->status_id = 5;
        if ($checklist->update()) {
            App::$app->session->setFlash('success', 'Data Rencana Tindakan Koreksi berhasil disubmit!');
            $response->back();
        }
    }

    public function inputAuditKriteria(Request $request, Response $response, $param)
    {
        $request = $request->getBody(null, 'contents/storage/data_pendukung');
        $checklist_has_kriteria = ChecklistHasKriteria::findOne($param);

        if (isset($request['ket_auditee'])) {
            $request['ket_auditee'] = htmlentities($request['ket_auditee']);
        }

        if (($checklist_has_kriteria->data_pendukung != '') && isset($request['data_pendukung']) && file_exists(APP_ROOT . "/" . $checklist_has_kriteria->data_pendukung)) {
            unlink(APP_ROOT . "/" . $checklist_has_kriteria->data_pendukung);
        }

        $checklist_has_kriteria->loadData($request);
        if ($checklist_has_kriteria->update()) {
            App::$app->session->setFlash('success', 'Data Rencana Tindakan Koreksi berhasil disimpan!');
            $response->back();
        }
    }

    public function submitAudit(Request $request, Response $response, $param)
    {
        $request = $request->getBody();
        $checklist = Checklist::findOne(['id' => $request['checklist_id']]);

        $checklist->status_id = 2;
        if ($checklist->update()) {
            App::$app->session->setFlash('success', 'Audit berhasil disubmit!');
            $response->back();
        }
    }
}