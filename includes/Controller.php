<?php

namespace app\includes;
/*
    * This is the Base Controller
    * Loads the Models and Views
*/
class Controller
{
    //  Default layout
    public string $layout = 'layout_example';

    // Load Model
    public function model($model)
    {
        // Requires Model FIle
        require_once APP_ROOT . '/admin/models/' . $model . '.php';

        // Instantiate Model
        return new $model();
    }

    // Load View
    public function view($view, $data = [])
    {
        if (file_exists(APP_ROOT . '/views/' . $view . '.php')) {
            $layoutContent = $this->layoutContent();
            $viewContent = $this->renderOnlyView($view, $data);
            return str_replace('{{content}}', $viewContent, $layoutContent);
//            require_once APPROOT . '/views/' . $view . '.php';
        }

        die('view does not exist');
    }

    /**
     * Render view that has been merged with layout template
     *
     */
    public function renderView($view, $data = [])           // ! BELUM KEPAKE
    {
        // Shift content template in layout with view
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $data);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Render main.php as a layout, which later will be used as a template and merged with custom content
     *
     */
    protected function layoutContent()
    {
        $layout = $this->layout;
        ob_start();         // start caching the output
        include_once APP_ROOT . "/views/layouts/$layout.php";       // actual output
        return ob_get_clean();          // return whatever is already buffered, and clears the buffer
    }

    /**
     * Render pure only from a view file
     *
     */
    protected function renderOnlyView($view, $data = [])
    {
        extract($data);
        ob_start();         // start caching the output
        include_once APP_ROOT . "/views/$view.php";       // actual output
        unset($data);
        return ob_get_clean();          // return whatever is already buffered, and clears the buffer
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * Generate random string
     *
     */
    public function randomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    /**
     * Generate random integer
     *
     */
    public function randomInteger($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789', ceil($length/strlen($x)) )),1,$length);
    }
}