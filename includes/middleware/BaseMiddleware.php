<?php

namespace app\includes\middleware;

abstract class BaseMiddleware
{
    abstract public function execute();
}