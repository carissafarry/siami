<?php
require_once dirname(__DIR__) . '/admin/init.php';

use app\admin\controllers\auth\AuthController;
use \app\includes\App;

$app = new App();

$app->db->applyMigrations();