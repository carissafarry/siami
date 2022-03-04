<?php

namespace app\admin\controllers;

use app\includes\Controller;

class Home extends Controller
{
    public function index()
    {
        // echo 'dari Home/Index';\

        $data = [
            'nama' => 'Rissa',
            'pekerjaan' => 'CEO',
        ];

        $this->view('spm/index', $data);
        // $this->view('spm/dashboard');
    }

    public function satu()
    {
        echo 'dari method Home.php/satu()';
    }
}