<?php

namespace app\includes;
/*
    * This is the Base Controller
    * Loads the Models and Views
*/
class Controller
{
    public string $layout = 'main';

    // Load Model
    public function model($model)
    {
        // Requires Model FIle
        require_once APPROOT . '/admin/models/' . $model . '.php';

        // Instantiate Model
        return new $model();
    }

    // Load View
    public function view($view, $data = [])
    {
        if (file_exists(APPROOT . '/views/' . $view . '.php')) {
            extract($data, EXTR_IF_EXISTS);
            unset($data);
            require_once APPROOT . '/views/' . $view . '.php';
        } else {
            die('view does not exist');
        }
    }

    public function setLayout($layout)          // !  masih belum kepake
    {
        $this->layout = $layout;
    }
}