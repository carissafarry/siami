<?php

namespace app\admin\controllers\spm;

use app\admin\models\Ami;
use app\admin\models\Area;
use app\admin\models\Auditee;
use app\admin\models\Auditor;
use app\admin\models\Checklist;
use app\admin\models\ChecklistAuditor;
use app\admin\models\ChecklistHasKriteria;
use app\admin\models\Kriteria;
use app\admin\models\Status;
use app\admin\rules\spm\manajemen_checklist\AddChecklistRule;
use app\includes\App;
use app\includes\Controller;
use app\includes\Request;
use app\includes\Response;

class ManajemenChecklistController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $amis = Ami::findAll();
        $last_ami = Ami::findOne(['id' => Ami::getLastInsertedRow()->id]);
        $checklists = Checklist::findAll('checklist', ['ami_id' => $last_ami->id]);
        $colors = [
            'primary', 'warning', 'info', 'danger', 'success',
        ];

        App::setLayout('layout');

        if ($request->isPost()) {
            $request = $request->getBody();

            //  Find checklist with given year
            $checklists = Checklist::findAll('checklist', ['ami_id' => $request['ami_id']]);
            $requested_ami = Ami::findOne(['id' => $request['ami_id']]);

            return App::view('spm/manajemen_checklist/index', [
                'checklists' => $checklists,
                'amis' => $amis,
                'tahun' => $requested_ami->tahun,
                'colors' => $colors,
            ]);
        }

        return App::view('spm/manajemen_checklist/index', [
            'checklists' => $checklists,
            'amis' => $amis,
            'tahun' => $last_ami->tahun,
            'colors' => $colors,
        ]);
    }

    public function add(Request $request, Response $response)
    {
        $checklist = new Checklist();
        $checklistDataRule = new AddChecklistRule($checklist);
        $checklist_has_kriteria = new ChecklistHasKriteria();
        $amis = Ami::findAll();
        $statuses = Status::findAll();
        $areas = Area::findAll();
        $auditee_users = [];
        $auditor_users = [];

        if ($request->isPost()) {
            $request = $request->getBody();

            //  Input data validation
            //  Change the input data type according to the data type in the database
            $key_to_int = ['id', 'ami_id', 'status_id', 'area_id', 'auditee_id', 'auditee2_id', 'auditor1_id', 'auditor2_id', 'auditor3_id'];
            foreach ($request as $key => $val) {
                if (isset($request[$key]) && in_array($key, $key_to_int)) {
                    $request[$key] = (int) $request[$key];
                    if ($request[$key] == 0) {
                        $request[$key] = null;
                    }
                }
            }
            
            //  Check and validate each kriteria_id and auditor_id input
            $kriteria_ids = [];
            $auditor_ids = [];
            foreach ($request as $key => $value) {
                if (strpos($key, 'kriteria') !== false) {
                    if ($value !== '') {
                        $kriteria = Kriteria::findOne(['id' => $value], 'kriteria', Kriteria::class);
                        if ($kriteria) {
                            $kriteria_ids[] = $value;
                        } else {
                            $checklistDataRule->addError($key, 'Kriteria with this id does not exist!');
                        }
                    } else {
                        $checklistDataRule->addError($key, 'This field is required');
                    }
                }
                if ((strpos($key, 'auditor') !== false) && ($key !== 'auditor3_id')) {
                    if ($value !== null) {
                        $auditor = Auditor::findOne(['user_id' => $value], 'auditor', Auditor::class);
                        if ($auditor) {
                            $auditor_ids[] = $value;
                        }
                    } else {
                        $checklistDataRule->addError($key, 'This field is required');
                    }
                }
            }

            //  Check whether the Auditee's and Auditor's input data has the same value
            if (isset($request['auditee2_id']) && ($request['auditee_id'] == $request['auditee2_id'])) {
                $checklistDataRule->addError('auditee_id', 'The value of Auditee Utama and Auditee Pengganti should not be the same');
                $checklistDataRule->addError('auditee2_id', 'The value of Auditee Utama and Auditee Pengganti should not be the same');
            }

            if ($request['auditor1_id'] == $request['auditor2_id']) {
                $checklistDataRule->addError('auditor1_id', 'The value of Auditor 1 and Auditor 2 should not be the same');
                $checklistDataRule->addError('auditor2_id', 'The value of Auditor 1 and Auditor 2 should not be the same');
            }

            //  Validate input data and create each data and the children data
            $checklist->loadData($request);
            if ($checklistDataRule->validate()) {
                if ($checklist->create()) {
                    $inserted_checklist_id = $checklist->getCurrentValue();
                    $checklist = Checklist::findOne(['id' => $inserted_checklist_id], 'checklist', Checklist::class);

                    foreach ($kriteria_ids as $kriteria_id) {
                        $checklist_has_kriteria->loadData([
                            'checklist_id' => $checklist->id,
                            'kriteria_id' => $kriteria_id,
                        ]);
                        if ($checklist_has_kriteria->create()) {
                            $inserted_checklist_has_kriteria_id = $checklist_has_kriteria->getCurrentValue();
                            $checklist_has_kriteria = ChecklistHasKriteria::findOne(['id' => $inserted_checklist_has_kriteria_id], 'checklist_has_kriteria', ChecklistHasKriteria::class);
                            foreach ($auditor_ids as $auditor_id) {
                                $checklist_auditor = new ChecklistAuditor();
                                $checklist_auditor->loadData([
                                    'checklist_kriteria_id' => $checklist_has_kriteria->id,
                                    'auditor_id' => $auditor_id,
                                ]);
                                $checklist_auditor->create();
                            }
                        }
                    }
                }

                App::$app->session->setFlash('success', 'Data berhasil ditambahkan!');
                $response->redirect('/spm/manajemen-checklist');
            }
        }

        App::setLayout('layout');
        return App::view('spm/manajemen_checklist/add', [
            'checklist' => $checklist,
            'amis' => $amis,
            'statuses' => $statuses,
            'areas' => $areas,
            'auditee_users' => $auditee_users,
            'auditor_users' => $auditor_users,
            'rule' => $checklistDataRule,
        ]);
    }

    public function update_area_data(Request $request, Response $response)
    {
        $request = $request->getBody();
        $tahun = Ami::findOrFail(['id' => $request['ami_id']], 'ami', null, null, 'tahun');
        $auditee_users = Auditee::users(['area_id' => $request['area_id'], 'tahun' => $tahun]);
        $auditor_users = Auditor::users(['area_id' => $request['area_id'], 'tahun' => $tahun]);

        $response->json([
            'success' => true,
            'message' => 'Data Standar berhasil diperbarui!',
            'auditee_users' => $auditee_users,
            'auditor_users' => $auditor_users,
            'area_id' => $request['area_id'],
            'tahun' => $tahun,
            'requests' => $request,
        ]);
    }

    public function update(Request $request, Response $response, $param)
    {
        $checklist = Checklist::findOrFail($param);
        $auditors = $checklist->auditors();
        $checklist_has_kriterias = ChecklistHasKriteria::findAll('checklist_has_kriteria', ['checklist_id' => $checklist->id], ChecklistHasKriteria::class);
        $colors = [
            'primary', 'warning', 'info', 'danger', 'success',
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
        return App::view('spm/manajemen_checklist/update', [
            'checklist' => $checklist,
            'checklist_has_kriterias' => $checklist_has_kriterias,
            'auditors' => $auditors,
            'prev_checklist_has_kriterias' => $prev_checklist_has_kriterias,
            'prev_period_auditors' => $prev_period_checklist ? $prev_period_checklist->auditors() : null,
            'colors' => $colors,
        ]);
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
        return App::view('spm/manajemen_checklist/detail_checklist_has_kriteria', [
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