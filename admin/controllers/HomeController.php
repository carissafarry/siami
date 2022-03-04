<?php

namespace app\admin\controllers;

use app\includes\Controller;
use app\includes\Request;

class HomeController extends Controller
{
    public function index()
    {
        // echo 'dari Home/Index';\

        $data = [
            'nama' => 'Rissa',
            'pekerjaan' => 'CEO',
        ];

        // $this->view('spm/index', $data);
        // $this->view('spm/dashboard');
    }

    public function form()
    {
        return $this->view('spm/form');
        // echo 'dari method Home.php/satu()';
    }

    public function satu()
    {
        return $this->view('spm/form');
        // echo 'dari method Home.php/satu()';
    }

    public function handleForm(Request $request)
    {
        $body = $request->getBody();
        
        echo '<pre>';
        var_dump($body);
        echo '</pre>';
        exit;
        
        return 'SUCCEED handling submitted data';
    }
}