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

$app->router->get('/root', [new AuthController(), 'index']);

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
$app->router->post('/spm/ami/detail/{id}', [new AmiController(), 'detail']);
$app->router->post('/spm/ami/detail/{id}/done', [new AmiController(), 'finishAmi']);
$app->router->get('/spm/ami/update/{id}', [new AmiController(), 'update']);
$app->router->post('/spm/ami/update/{id}', [new AmiController(), 'update']);
$app->router->post('/spm/ami/delete/{id}', [new AmiController(), 'delete']);

$app->router->get('/spm/manajemen-kriteria', [new ManajemenKriteriaController(), 'index']);
$app->router->get('/spm/manajemen-kriteria/{tahun}', [new ManajemenKriteriaController(), 'index']);
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
$app->router->get('/spm/manajemen-checklist/{tahun}', [new ManajemenChecklistController(), 'index']);
$app->router->post('/spm/manajemen-checklist', [new ManajemenChecklistController(), 'index']);
$app->router->get('/spm/manajemen-checklist/add', [new ManajemenChecklistController(), 'add']);
$app->router->post('/spm/manajemen-checklist/add', [new ManajemenChecklistController(), 'add']);
$app->router->post('/spm/manajemen-checklist/update-area-data', [new ManajemenChecklistController(), 'update_area_data']);
$app->router->get('/spm/manajemen-checklist/update/{id}', [new ManajemenChecklistController(), 'update']);
$app->router->get('/spm/manajemen-checklist/update/{checklist_id}/i/{id}', [new ManajemenChecklistController(), 'detail_checklist_has_kriteria']);
$app->router->get('/spm/manajemen-checklist/view/{id}', [new ManajemenChecklistController(), 'viewFile']);
$app->router->post('/spm/manajemen-checklist/delete/{id}', [new ManajemenChecklistController(), 'delete']);
$app->router->get('/spm/manajemen-checklist/export/{id}', [new ManajemenChecklistController(), 'exportRTM']);



// Auditee
$app->router->get('/auditee/checklist', [new AuditeeChecklistController(), 'index']);
$app->router->get('/auditee/checklist/{tahun}', [new AuditeeChecklistController(), 'index']);
$app->router->get('/auditee/checklist/update/{id}', [new AuditeeChecklistController(), 'update']);
$app->router->post('/auditee/checklist/update/{checklist_id}/s', [new AuditeeChecklistController(), 'saveChecklistKriteria']);
$app->router->get('/auditee/checklist/view/{id}', [new AuditeeChecklistController(), 'viewFile']);
$app->router->get('/auditee/checklist/update/{checklist_id}/i/{id}', [new AuditeeChecklistController(), 'detail_checklist_has_kriteria']);
$app->router->post('/auditee/checklist/update/{checklist_id}/i/{id}', [new AuditeeChecklistController(), 'detail_checklist_has_kriteria']);
$app->router->post('/auditee/checklist/update/{checklist_id}/submit-rtm', [new AuditeeChecklistController(), 'submitTindakLanjut']);
$app->router->post('/auditee/checklist/update/{checklist_id}/submit-audit', [new AuditeeChecklistController(), 'submitAudit']);
$app->router->post('/auditee/checklist/update/{checklist_id}/i/{id}/input-audit-kriteria', [new AuditeeChecklistController(), 'inputAuditKriteria']);



// Auditor
$app->router->get('/auditor/checklist', [new AuditorChecklistController(), 'index']);
$app->router->get('/auditor/checklist/{tahun}', [new AuditorChecklistController(), 'index']);
$app->router->get('/auditor/checklist/update/{id}', [new AuditorChecklistController(), 'update']);
//$app->router->post('/auditor/checklist/update/{checklist_id}/s', [new AuditorChecklistController(), 'saveChecklistKriteria']);
$app->router->post('/auditor/checklist/submit', [new AuditorChecklistController(), 'submitAudit']);
$app->router->get('/auditor/checklist/update/{checklist_id}/i/{id}', [new AuditorChecklistController(), 'detail_checklist_has_kriteria']);
$app->router->post('/auditor/checklist/update/{checklist_id}/i/{id}/save-audit', [new AuditorChecklistController(), 'saveAudit']);
$app->router->post('/auditor/checklist/update/{checklist_id}/i/{id}/save-audit', [new AuditorChecklistController(), 'saveAudit']);
$app->router->get('/auditor/checklist/view/{id}', [new AuditorChecklistController(), 'viewFile']);
$app->router->post('/auditor/checklist/save-tinjauan-efektivitas', [new AuditorChecklistController(), 'saveTinjauanEfektivitas']);


$app->run();