<?php
/** @var $rule \app\admin\rules\auth\UserRule */
?>

<h1>Create your account</h1>

<?php $form = \app\admin\models\auth\form\Form::begin('', "post") ?>
    <div class="row">
        <div class="col">
            <?= $form->field($rule, 'firstname') ?>
        </div>
        <div class="col">
            <?= $form->field($rule, 'lastname') ?>
        </div>
    </div>
    <?= $form->field($rule, 'email') ?>
    <?= $form->field($rule, 'password')->passwordField() ?>
    <?= $form->field($rule, 'confirmPassword')->passwordField() ?>

    <button type="submit" class="btn btn-primary">Submit</button>
<?= \app\admin\models\auth\form\Form::end() ?>