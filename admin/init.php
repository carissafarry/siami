<?php

require_once dirname(__DIR__) . '/includes/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

require_once dirname(__DIR__) . '/includes/config.php';
require_once APP_ROOT . '/includes/App.php';
require_once APP_ROOT . '/includes/Controller.php';