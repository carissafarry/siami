<?php

namespace app\includes;
/*
    * This is the Base Controller
    * Loads the Models and Views
*/
class Controller
{
    //  Default layout
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
        include_once APPROOT . "/views/layouts/$layout.php";       // actual output
        return ob_get_clean();          // return whatever is already buffered, and clears the buffer
    }

    /**
     * Render pure only from a view file
     *
     */
    protected function renderOnlyView($view, $data = [])
    {
        extract($data, EXTR_IF_EXISTS);
        ob_start();         // start caching the output
        include_once APPROOT . "/views/$view.php";       // actual output
        unset($data);
        return ob_get_clean();          // return whatever is already buffered, and clears the buffer
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}