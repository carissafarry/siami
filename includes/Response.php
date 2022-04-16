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
}