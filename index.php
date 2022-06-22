<?php
require_once __DIR__ . '/admin/init.php';

use app\admin\controllers\auth\AuthController;
use app\admin\controllers\spm\AmiController;
use app\admin\controllers\auditee\AuditeeChecklistController;
use app\admin\controllers\auditor\AuditorChecklistController;
use app\admin\controllers\FileUploadController;
use app\admin\controllers\spm\ManajemenUserController;
use app\admin\controllers\spm\ManajemenKriteriaController;
use app\admin\controllers\spm\ManajemenChecklistController;
use app\includes\App;

$app = new App();

//$app->router->get('/', function () {
//    return http_redirect('/login');
//});
//$app->router->get('/contact', 'contact');       // use string argument to display directly from a view file

$app->router->get('/', [new AuthController(), 'index']);
$app->router->get('/login', [new AuthController(), 'login']);
$app->router->post('/login', [new AuthController(), 'login']);
$app->router->get('/register', [new AuthController(), 'register']);
$app->router->post('/register', [new AuthController(), 'register']);
$app->router->get('/logout', [new AuthController(), 'logout']);

$app->router->get('/dashboard', [new AuthController(), 'dashboard']);
$app->router->get('/profile', [new AuthController(), 'profile']);
$app->router->post('/profile', [new AuthController(), 'profile']);



// SPM
$app->router->get('/spm/manajemen-user', [new ManajemenUserController(), 'index']);
$app->router->get('/spm/manajemen-user/add', [new ManajemenUserController(), 'add']);
$app->router->post('/spm/manajemen-user/add', [new ManajemenUserController(), 'add']);
$app->router->get('/spm/manajemen-user/detail/{id}', [new ManajemenUserController(), 'detail']);
$app->router->get('/spm/manajemen-user/update/{id}', [new ManajemenUserController(), 'update']);
$app->router->post('/spm/manajemen-user/update/{id}', [new ManajemenUserController(), 'update']);
$app->router->post('/spm/manajemen-user/delete/{id}', [new ManajemenUserController(), 'delete']);

$app->router->get('/spm/ami', [new AmiController(), 'index']);
$app->router->get('/spm/ami/add', [new AmiController(), 'add']);
$app->router->post('/spm/ami/add', [new AmiController(), 'add']);
$app->router->get('/spm/ami/detail/{id}', [new AmiController(), 'detail']);
$app->router->get('/spm/ami/update/{id}', [new AmiController(), 'update']);
$app->router->post('/spm/ami/update/{id}', [new AmiController(), 'update']);
$app->router->post('/spm/ami/delete/{id}', [new AmiController(), 'delete']);

$app->router->get('/spm/manajemen-kriteria', [new ManajemenKriteriaController(), 'index']);
$app->router->post('/spm/manajemen-kriteria', [new ManajemenKriteriaController(), 'index']);
$app->router->get('/spm/manajemen-kriteria/k/add', [new ManajemenKriteriaController(), 'add_kriteria']);
$app->router->post('/spm/manajemen-kriteria/k/add', [new ManajemenKriteriaController(), 'add_kriteria']);
$app->router->post('/spm/manajemen-kriteria/k/update-standar-data', [new ManajemenKriteriaController(), 'update_standar_data']);
$app->router->get('/spm/manajemen-kriteria/k/detail/{id}', [new ManajemenKriteriaController(), 'detail_kriteria']);
$app->router->get('/spm/manajemen-kriteria/k/update/{id}', [new ManajemenKriteriaController(), 'update_kriteria']);
$app->router->post('/spm/manajemen-kriteria/k/update/{id}', [new ManajemenKriteriaController(), 'update_kriteria']);
$app->router->post('/spm/manajemen-kriteria/k/delete/{id}', [new ManajemenKriteriaController(), 'delete_kriteria']);
$app->router->get('/spm/manajemen-kriteria/s/add', [new ManajemenKriteriaController(), 'add_standar']);
$app->router->post('/spm/manajemen-kriteria/s/add', [new ManajemenKriteriaController(), 'add_standar']);
$app->router->get('/spm/manajemen-kriteria/s/detail/{id}', [new ManajemenKriteriaController(), 'detail_standar']);
$app->router->get('/spm/manajemen-kriteria/s/update/{id}', [new ManajemenKriteriaController(), 'update_standar']);
$app->router->post('/spm/manajemen-kriteria/s/update/{id}', [new ManajemenKriteriaController(), 'update_standar']);
$app->router->post('/spm/manajemen-kriteria/s/delete/{id}', [new ManajemenKriteriaController(), 'delete_standar']);

$app->router->get('/spm/manajemen-checklist', [new ManajemenChecklistController(), 'index']);
$app->router->post('/spm/manajemen-checklist', [new ManajemenChecklistController(), 'index']);
$app->router->get('/spm/manajemen-checklist/add', [new ManajemenChecklistController(), 'add']);
$app->router->post('/spm/manajemen-checklist/add', [new ManajemenChecklistController(), 'add']);



// Auditee
$app->router->get('/auditee/checklist', [new AuditeeChecklistController(), 'index']);
$app->router->get('/auditee/checklist/detail/{id}', [new AuditeeChecklistController(), 'detail']);
$app->router->post('/auditee/checklist/detail/{checklist_id}/s', [new AuditeeChecklistController(), 'saveChecklistKriteria']);
$app->router->get('/auditee/checklist/view/{id}', [new AuditeeChecklistController(), 'viewFile']);
$app->router->post('/auditee/checklist/detail/{checklist_id}/i/{checklist_has_kriteria_id}', [new AuditeeChecklistController(), 'detail_checklist_has_kriteria']);



// Auditor
$app->router->get('/auditor/checklist', [new AuditorChecklistController(), 'index']);
$app->router->get('/auditor/checklist/detail/{id}', [new AuditorChecklistController(), 'detail']);
$app->router->post('/auditor/checklist/detail/{checklist_id}/s', [new AuditorChecklistController(), 'saveChecklistKriteria']);


$app->run();