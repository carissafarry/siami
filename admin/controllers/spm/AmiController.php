<?php

namespace app\admin\controllers\spm;

use app\admin\models\Ami;
use app\admin\models\Spm;
use app\admin\rules\spm\ami\AddAmiRule;
use app\admin\rules\spm\ami\AddJadwalRtm;
use app\admin\rules\spm\ami\UpdateAmiRule;
use app\includes\App;
use app\includes\Controller;
use app\includes\Request;
use app\includes\Response;

class AmiController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $amis = Ami::findAll();

        App::setLayout('layout');
        return App::view('spm/ami/index', [
            'amis' => $amis
        ]);
    }

    public function add(Request $request, Response $response)
    {
        $ami = new Ami();
        $amiDataRule = new AddAmiRule($ami);
        $spms = Spm::findAll();

        if ($request->isPost()) {
            $request = $request->getBody();

            //  Check if jadwal_selesai is not greater than jadwal_mulai
            if ($request['audit_selesai'] <= $request['audit_mulai']) {
                $amiDataRule->addError('audit_mulai', 'Jadwal Mulai has to be lower than Jadwal Selesai');
                $amiDataRule->addError('audit_selesai', 'Jadwal Selesai has to be greater than Jadwal Mulai');
            }

//            if (isset($request['is_tindak_lanjut'])) {
//                $request['is_tindak_lanjut'] = 1;
//            } else {
//                $request['is_tindak_lanjut'] = 0;
//            }

            $ami->loadData($request);
            if ($amiDataRule->validate() && $ami->create()) {
                App::$app->session->setFlash('success', 'Data berhasil ditambahkan!');
                $response->redirect('/spm/ami');
            }
        }

        App::setLayout('layout');
        return App::view('spm/ami/add', [
            'ami' => $ami,
            'rule' => $amiDataRule,
            'spms' => $spms,
        ]);
    }

    public function detail(Request $request, Response $response, $param)
    {
        $ami = Ami::findOrFail($param);
        $waktu_audits = $ami->checklists('waktu_audit');
        if ($waktu_audits != []) {
            $are_all_audited = !in_array(null, $waktu_audits);
        } else {
            $are_all_audited = false;
        }

        if ($request->isPost()) {
            $request = $request->getBody();
            $amiDataRule = new AddJadwalRtm($ami);
            $checklists = $ami->checklists();
            foreach ($checklists as $checklist) {
                $checklist->status_id = 4;
                $checklist->update();
            }

            $ami->loadData($request);
            if ($amiDataRule->validate() && $ami->update()) {
                $response->json([
                    'success' => true,
                    'message' => 'Jadwal berhasil ditambahkan!',
                ]);
            }
        }

        App::setLayout('layout');
        return App::view('spm/ami/detail', [
            'ami' => $ami,
            'are_all_audited' => $are_all_audited,
        ]);
    }

    /**
     * @throws \app\includes\exception\NotFoundException
     */
    public function update(Request $request, Response $response, $param)
    {
        $ami = Ami::findOrFail($param);
        $amiDataRule = new UpdateAmiRule($ami);
        $spms = Spm::findAll();

        if ($request->isPost()) {
            $request = $request->getBody();

            //  Check if jadwal_selesai is not greater than jadwal_mulai
            if ($request['audit_selesai'] <= $request['audit_mulai']) {
                $amiDataRule->addError('audit_mulai', 'Jadwal Mulai has to be lower than Jadwal Selesai');
                $amiDataRule->addError('audit_selesai', 'Jadwal Selesai has to be greater than Jadwal Mulai');
            }

//            if (isset($request['is_tindak_lanjut']) && ($request['is_tindak_lanjut'] == 'on')) {
//                $request['is_tindak_lanjut'] = 1;
//            } else {
//                $request['is_tindak_lanjut'] = 0;
//            }

            $ami->loadData($request);
            if ($amiDataRule->validate() && $ami->update()) {
                App::$app->session->setFlash('success', 'Data berhasil diupdate!');
                $response->redirect('/spm/ami');
            }
        }

        App::setLayout('layout');
        return App::view('spm/ami/update', [
            'ami' => $ami,
            'rule' => $amiDataRule,
            'spms' => $spms,
        ]);
    }

    /**
     * @throws \app\includes\exception\NotFoundException
     */
    public function delete(Request $request, Response $response, $param): void
    {
        $ami = $this->repo(Ami::findOrFail($param));
        if ($ami->delete($param)) {
            App::$app->session->setFlash('success', 'Data berhasil dihapus!');
            $response->back();
            return;
        }
        App::$app->session->setFlash('failed', 'Data gagal dihapus!');
        $response->back();
    }

}