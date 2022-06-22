<?php

namespace app\includes;

class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }

    public function back()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function json(array $data)
    {
        ob_clean();
        header_remove();
        header("Content-type: application/json; charset=utf-8");
        http_response_code(200);
        echo json_encode($data);
        exit();
    }

    public function file(string $path, array $headers=[])
    {
        $file_directory = APP_ROOT . "/" . $path;
        if (file_exists($file_directory)) {
            $file_name = pathinfo($path, PATHINFO_FILENAME);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Cache-Control: public"); // needed for internet explorer
            header("Content-Type: application/octet-stream");
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length: ".filesize($file_directory));
            header("Content-Disposition: attachment; filename={$file_name}.{$extension}");
            readfile($file_directory);
            die();
        } else {
            die("Error: file not found!");
        }
    }
}