<?php

namespace app\includes;

class Request
{
    /**
     * Get the server request path
     *
     */
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // Get position of question mark
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }

        // If there is question mark / there is request (e.g. home/index?user=1), return actual path
        return substr($path, 0, $position);
    }

    /**
     * Check request method
     *
     */
    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Check if request is from GET method
     *
     */
    public function isGet()
    {
        return $this->method() === 'get';
    }

    /**
     * Check if request is from POST method
     *
     */
    public function isPost()
    {
        return $this->method() === 'post';
    }

    /**
     * Filter some malicious characters or invalid symbols from inputted data to have secure body data
     *
     */
    public function getBody($data = [])
    {
        $body = [];

        if (empty($data)) {
            if ($this->method() === 'get') {
                foreach ($_GET as $key => $value) {
                    $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
            if ($this->method() === 'post') {
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        } else {
            foreach ($data as $key => $value) {
                $body[$key] = $value;
            }
        }

        return $body;
    }
}