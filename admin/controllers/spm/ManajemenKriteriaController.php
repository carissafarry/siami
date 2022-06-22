<?php

namespace app\admin\controllers\spm;

use app\admin\models\Ami;
use app\admin\models\Kriteria;
use app\admin\models\Standar;
use app\admin\rules\spm\manajemen_kriteria\KriteriaRule;
use app\admin\rules\spm\manajemen_kriteria\StandarRule;
use app\includes\App;
use app\includes\Controller;
use app\includes\Request;
use app\includes\Response;

class ManajemenKriteriaController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $amis = Ami::findAll();
        $last_ami = Ami::findOne(['id' => Ami::getLastInsertedRow()->id]);
        $standars = Standar::findAll('standar', ['tahun' => $last_ami->tahun]);
        $kriterias = Kriteria::findAll('kriteria', ['tahun' => $last_ami->tahun]);

        App::setLayout('layout');

        if ($request->isPost()) {
            $request = $request->getBody();
            $standars = Standar::findAll('standar', ['tahun' => $request['tahun']]);
            $kriterias = Kriteria::findAll('kriteria', ['tahun' => $request['tahun']]);

            return App::view('spm/manajemen_kriteria/index', [
                'amis' => $amis,
                'standars' => $standars,
                'kriterias' => $kriterias,
                'tahun' => $request['tahun'],
            ]);
        }

        return App::view('spm/manajemen_kriteria/index', [
            'amis' => $amis,
            'standars' => $standars,
            'kriterias' => $kriterias,
            'tahun' => $last_ami->tahun,
        ]);
    }

    public function add_kriteria(Request $request, Response $response)
    {
        $kriteria = new Kriteria();
        $kriteriaDataRule = new KriteriaRule($kriteria);
        $amis = Ami::findAll();
        $standars = Standar::findAll('standar', ['tahun' => date('Y')]);

        if ($request->isPost()) {
            $request = $request->getBody();
            $kriteria->loadData($request);

            if ($kriteriaDataRule->validate() && $kriteria->create()) {
                App::$app->session->setFlash('success', 'Data berhasil ditambahkan!');
                $response->redirect('/spm/manajemen-kriteria');
            }
        }

        App::setLayout('layout');
        return App::view('spm/manajemen_kriteria/kriteria/add', [
            'kriteria' => $kriteria,
            'standars' => $standars,
            'amis' => $amis,
            'rule' => $kriteriaDataRule,
        ]);
    }

    public function detail_kriteria(Request $request, Response $response, $param)
    {
        $kriteria = Kriteria::findOrFail($param);

        App::setLayout('layout');
        return App::view('spm/manajemen_kriteria/kriteria/detail', [
            'kriteria' => $kriteria
        ]);
    }

    public function update_kriteria(Request $request, Response $response, $param)
    {
        $kriteria = Kriteria::findOrFail($param);
        $standars = Standar::findAll('standar', ['tahun' => $kriteria->tahun]);
        $amis = Ami::findAll();
        $kriteriaDataRule = new KriteriaRule($kriteria);

        if ($request->isPost()) {
            $request = $request->getBody();
            $kriteria->loadData($request);

            if ($kriteriaDataRule->validate() && $kriteria->update()) {
                App::$app->session->setFlash('success', 'Data berhasil diupdate!');
                $response->redirect('/spm/manajemen-kriteria');
            }
        }

        App::setLayout('layout');
        return App::view('spm/manajemen_kriteria/kriteria/update', [
            'kriteria' => $kriteria,
            'standars' => $standars,
            'amis' => $amis,
            'rule' => $kriteriaDataRule,
        ]);
    }

    public function delete_kriteria(Request $request, Response $response, $param)
    {
        $kriteria = $this->repo(Kriteria::findOrFail($param));
        if ($kriteria->delete($param)) {
            App::$app->session->setFlash('success', 'Data berhasil dihapus!');
            $response->back();
            return ;
        }
        App::$app->session->setFlash('failed', 'Data gagal dihapus!');
        $response->back();
    }

    public function add_standar(Request $request, Response $response)
    {
        $standar = new Standar();
        $amis = Ami::findAll();
        $standarDataRule = new StandarRule($standar);

        if ($request->isPost()) {
            $request = $request->getBody();
            $standar->loadData($request);

            if ($standarDataRule->validate() && $standar->create()) {
                App::$app->session->setFlash('success', 'Data berhasil ditambahkan!');
                $response->redirect('/spm/manajemen-kriteria');
            }
        }

        App::setLayout('layout');
        return App::view('spm/manajemen_kriteria/standar/add', [
            'standar' => $standar,
            'amis' => $amis,
            'rule' => $standarDataRule,
        ]);
    }

    public function detail_standar(Request $request, Response $response, $param)
    {
        $standar = Standar::findOrFail($param);

        App::setLayout('layout');
        return App::view('spm/manajemen_kriteria/standar/detail', [
            'standar' => $standar
        ]);
    }

    public function update_standar(Request $request, Response $response, $param)
    {
        $standar = Standar::findOrFail($param);
        $amis = Ami::findAll();
        $standarDataRule = new StandarRule($standar);

        if ($request->isPost()) {
            $request = $request->getBody();
            $standar->loadData($request);

            if ($standarDataRule->validate() && $standar->update()) {
                App::$app->session->setFlash('success', 'Data berhasil diupdate!');
                $response->redirect('/spm/manajemen-kriteria');
            }
        }

        App::setLayout('layout');
        return App::view('spm/manajemen_kriteria/standar/update', [
            'standar' => $standar,
            'amis' => $amis,
            'rule' => $standarDataRule,
        ]);
    }

    public function delete_standar(Request $request, Response $response, $param)
    {
        $standar = $this->repo(Standar::findOrFail($param));
        if ($standar->delete($param)) {
            App::$app->session->setFlash('success', 'Data berhasil dihapus!');
            $response->back();
            return ;
        }
        App::$app->session->setFlash('failed', 'Data gagal dihapus!');
        $response->back();
    }

    public function update_standar_data(Request $request, Response $response, $param)
    {
        $request = $request->getBody();
        $standars = Standar::findAll('standar', ['tahun' => $request['tahun']]);

        $response->json([
            'success' => true,
            'message' => 'Data Standar berhasil diperbarui!',
            'standars' => $standars,
        ]);
    }
}