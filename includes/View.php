<?php

namespace app\includes;

class View
{
    public string $title = '';
    public string $layout = 'layout_example';       //  Default layout

    // Load View
    public function view($view, $data = [])
    {
        if (file_exists(APP_ROOT . '/views/' . $view . '.php')) {
            return $this->renderView($view, $data);
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
        $viewContent = $this->render($view, $data);
        $layoutContent = $this->layoutContent();
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
    protected function render($view, $data = [])
    {
        extract($data);
        ob_start();         // start caching the output
        include_once APP_ROOT . "/views/$view.php";       // actual output
        unset($data);
        return ob_get_clean();          // return whatever is already buffered, and clears the buffer
    }

    /**
     * Define which layout will be used before render the View
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}