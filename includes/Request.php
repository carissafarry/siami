<?php

namespace app\includes;

use http\Exception\RuntimeException;

class Request
{
    /**
     * Get the server request path
     * @return string
     */
    public function getPath(): string
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
     * @return string
     */
    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Check if request is from GET method
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->method() === 'get';
    }

    /**
     * Check if request is from POST method
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->method() === 'post';
    }

    /**
     * Check if request is from given url
     * @param $url
     * @return bool
     */
    public function is($url): bool
    {
        if (str_contains($_SERVER['REQUEST_URI'], strtolower($url))) {
            return True;
        }
        return False;
    }

    /**
     * Filter some malicious characters or invalid symbols from inputted data to have secure body data
     * @param array|null $data_type Define each data type of input
     * @param string $uploaded_files_directory Define where uploaded files will be moved
     * @return array
     */
    public function getBody(?array $data_type = [], string $uploaded_files_directory='contents/storage'): array
    {
        $body = [];

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

        //  move_uploaded_file ensures that uploaded file is a valid file (uploaded via PHP's HTTP POST)
        foreach ($_FILES as $key => $value) {
            if (($value['error'] == 0) && ($value['name'] != '')) {
                $extension = pathinfo($value['name'], PATHINFO_EXTENSION);
                $baseName = md5(uniqid(rand(), true)) . "_" . time() . "." . $extension;
                $body[$key] = "{$uploaded_files_directory}/{$baseName}";

                //  Return empty array if valid uploaded file cannot be moved for some reason
                if (!move_uploaded_file($value['tmp_name'], $body[$key])) {
                    $errorMsg = "Failed to move uploaded file '{$value['name']}' as '{$body[$key]}'!";
                    if (!isset($body['error'])) {
                        $body = [];
                    }
                    $body['error'][] = $errorMsg;
                }
            }
        }

        if (!is_null($data_type)) {
            foreach ($data_type as $key => $value) {
                if ($value == 'int') {
                    $body[$key] = (int) $body[$key];
                } else if ($value == 'float') {
                    $body[$key] = (float) $body[$key];
                }
            }
        }

        return $body;
    }
}