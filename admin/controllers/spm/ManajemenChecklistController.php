<?php

namespace app\admin\controllers\spm;

use app\admin\middleware\AuthMiddleware;
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
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ManajemenChecklistController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(
            new AuthMiddleware([
                'index',
                'add',
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
        $are_all_done = true;

        $checklists = Checklist::findAll('checklist', ['ami_id' => $ami->id]);
        $colors = [
            'primary', 'warning', 'info', 'danger', 'warning', 'success',
        ];

        //  Check if any checklist is not done yet
        $checklist_statuses = Checklist::findAll('checklist', ['ami_id' => $ami->id], null, null, 'status_id');
        if (in_array(1, $checklist_statuses) || in_array(2, $checklist_statuses) || in_array(3, $checklist_statuses) || in_array(4, $checklist_statuses) || empty($checklist_statuses)) {
            $are_all_done = false;
        }
        
        App::setLayout('layout');
        return App::view('spm/manajemen_checklist/index', [
            'checklists' => $checklists,
            'ami' => $ami,
            'ami_years' => $ami_years,
            'tahun' => $tahun,
            'are_all_done' => $are_all_done,
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
                        $kriteria = Kriteria::findOne(['kode' => $value], 'kriteria', Kriteria::class);
                        if ($kriteria) {
                            $kriteria_ids[] = $kriteria->id;
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
            'primary', 'warning', 'info', 'danger', 'warning', 'success',
        ];

        //  Look for previous period checklist data
        $prev_period_ami = Ami::findOne(['tahun' => ($checklist->ami()->tahun - 1)]);
        $prev_period_checklist = false;
        $prev_checklist_has_kriterias = [];
        $same_prev_checklist_has_kriterias = [];

        if ($prev_period_ami) {
            $prev_period_checklist = Checklist::findOne([
                'ami_id' => $prev_period_ami->id,
                'area_id' => $checklist->area_id,
            ]);

            if ($prev_period_checklist) {
                $prev_checklist_has_kriterias = ChecklistHasKriteria::findAll('checklist_has_kriteria', ['checklist_id' => $prev_period_checklist->id], ChecklistHasKriteria::class);
                foreach ($checklist_has_kriterias as $checklist_has_kriteria) {
                    foreach ($prev_checklist_has_kriterias as $prev_checklist_has_kriteria) {
                        if (preg_replace( "/\r|\n/", "", strtolower($checklist_has_kriteria->kriteria()->kriteria)) == preg_replace( "/\r|\n/", "", strtolower($prev_checklist_has_kriteria->kriteria()->kriteria))){
                            $same_prev_checklist_has_kriterias[] = $prev_checklist_has_kriteria->kriteria()->kriteria;
                        }
                    }
                }
            }
        }

        App::setLayout('layout');
        return App::view('spm/manajemen_checklist/update', [
            'checklist' => $checklist,
            'checklist_has_kriterias' => $checklist_has_kriterias,
            'auditors' => $auditors,
            'prev_checklist_has_kriterias' => $prev_checklist_has_kriterias,
            'prev_period_auditors' => $prev_period_checklist ? $prev_period_checklist->auditors() : null,
            'same_prev_checklist_has_kriterias' => $same_prev_checklist_has_kriterias,
            'colors' => $colors,
        ]);
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
        return App::view('spm/manajemen_checklist/detail_checklist_has_kriteria', [
            'last_ami' => $last_ami,
            'last_year_ami' => $last_year_ami,
            'checklist_has_kriteria' => $checklist_has_kriteria,
            'checklist_auditors' => $checklist_auditors,
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

    public function delete(Request $request, Response $response, $param)
    {
        $checklist_has_kriterias = ChecklistHasKriteria::findAll('checklist_has_kriteria', ['checklist_id' => $param['id']]);
        foreach ($checklist_has_kriterias as $checklist_has_kriteria) {
            $checklist_auditors = $checklist_has_kriteria->checklist_auditors();
            foreach ($checklist_auditors as $checklist_auditor) {
                $checklist_auditor->delete(['id' => $checklist_auditor->id]);
            }
            if ($checklist_has_kriteria->checklist_auditors() == []) {
                if (($checklist_has_kriteria->data_pendukung != '') && file_exists(APP_ROOT . "/" . $checklist_has_kriteria->data_pendukung)) {
                    unlink(APP_ROOT . "/" . $checklist_has_kriteria->data_pendukung);
                }
                $checklist_has_kriteria->delete(['id' => $checklist_has_kriteria->id]);
            }
        }
        if (ChecklistHasKriteria::findAll('checklist_has_kriteria', ['checklist_id' => $param['id']]) == []) {
            $checklist = Checklist::findOne($param);
            if ($checklist->delete($param)) {
                App::$app->session->setFlash('success', 'Data berhasil dihapus!');
                $response->back();
            }
        }
    }

    public function exportRTM(Request $request, Response $response, $param)
    {
        $ami = Ami::findOne($param);
        $checklists = $ami->checklists();

        //  Create reader
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = new Spreadsheet();
        foreach ($checklists as $checklist) {
            if ($checklist->status_id >= 5) {
                //  Load existing template file
                $template_spreadsheet = $reader->load(APP_ROOT . "/" . 'contents/storage/Template_RTM.xlsx');
                $laporanAuditSheet = clone $template_spreadsheet->getSheetByName('Laporan Audit');
                $worksheet = $spreadsheet->addExternalSheet($laporanAuditSheet);

                //  Set template contents
                $worksheet->setTitle($checklist->area()->nama . ' ' . ($checklist->area()->is_prodi == 1 ? $checklist->area()->jurusan : ''));
                $worksheet
                    ->setCellValue("A5", "FM-PJM." . substr($checklist->no_identifikasi, -5) . ".Rev." . sprintf("%02d", $checklist->no_revisi))
                    ->setCellValue("C4", 'Area: ' . $checklist->area()->nama. ' ' . ($checklist->area()->is_prodi == 1 ? $checklist->area()->jurusan : ''))
                    ->setCellValue("Q1", $checklist->no_identifikasi)
                    ->setCellValue("Q2", $checklist->no_revisi)
                ;
                $tgl_terbit = date_create($checklist->tgl_terbit);
                $worksheet
                    ->setCellValue("Q3", date_format($tgl_terbit, 'd F Y'))
                    ->setCellValue("D9", $checklist->area()->nama. ' ' . ($checklist->area()->is_prodi == 1 ? $checklist->area()->jurusan : ''))
                    ->setCellValue("D10", $checklist->auditee()->user()->nama)
                ;
                if ($checklist->auditee2()) {
                    $worksheet
                        ->setCellValue("B11", 'Auditee2')
                        ->setCellValue("C11", ':')
                        ->setCellValue("D11", $checklist->auditee2()->user()->nama)
                    ;
                }

                $auditor_row = 12;
                if (count($checklist->auditors()) >= 3) {
                    $worksheet
                        ->setCellValue("B14", 'Auditor3')
                        ->setCellValue("C14", ':')
                    ;
                }
                foreach ($checklist->auditors() as $auditor) {
                    $worksheet->setCellValue("D{$auditor_row}", $auditor->user()->nama);
                    $auditor_row++;
                }

                $waktu_audit = date_create($checklist->waktu_audit);
                $worksheet->setCellValue("D16", date_format($waktu_audit, "l, j F Y / H:i"));

                $rtm_mulai = date_create($ami->rtm_mulai);
                $rtm_selesai = date_create($ami->rtm_selesai);
                $worksheet->setCellValue("P21", date_format($rtm_mulai, "l, j F Y / H:i") . ' - ' . date_format($rtm_selesai, "l, j F Y / H:i"));

                //  Set main contents
                $checklist_has_kriterias = $checklist->pivot();
                $no = 1;
                $kts_row = 23;
                foreach ($checklist_has_kriterias as $checklist_has_kriteria) {
                    if ($checklist_has_kriteria->tidak_sesuai == 1) {
                        if ($kts_row !== 23) {
                            $worksheet->insertNewRowBefore($kts_row);
                        }
                        $worksheet
                            ->mergeCells("C{$kts_row}:F{$kts_row}")
                            ->mergeCells("H{$kts_row}:K{$kts_row}")
                            ->mergeCells("O{$kts_row}:Q{$kts_row}")
                            ->setCellValue("B{$kts_row}", $no)
                            ->setCellValue("H{$kts_row}", html_entity_decode($checklist_has_kriteria->tindak_lanjut))
                            ->setCellValue("O{$kts_row}", html_entity_decode($checklist_has_kriteria->tinjauan_efektivitas))
                        ;
                        $ket_auditors = '';
                        foreach ($checklist_has_kriteria->checklist_auditors() as $checklist_auditor) {
                            if ($checklist_auditor) {
                                $ket_auditors .= ($checklist_auditor->ket_auditor . '&#10;');
                            }
                        }
                        $worksheet->setCellValue("C{$kts_row}", html_entity_decode($ket_auditors));
                        $no++;
                        $kts_row++;
                    }
                }

                //  Set signature contents
                $highest_row = $worksheet->getHighestRow();
                if ($checklist->auditee2()) {
                    $worksheet
                        ->setCellValue("E" . ($highest_row-5), "Auditee2:")
                        ->setCellValue("E{$highest_row}", "=D11")
                    ;
                }
                if (count($checklist->auditors()) >= 3) {
                    $worksheet
                        ->setCellValue("Q" . ($highest_row-5), "Auditor3:")
                        ->setCellValue("Q{$highest_row}", "=D14")
                    ;
                }
            }
        }

        //  Export to user
        $spreadsheet->removeSheetByIndex(0);
        $response->excel($spreadsheet, 'Rapat Tinjauan Manajemen');
    }
}