<?php
/** @var $rule \app\admin\rules\auth\UserRule */
?>

<h1>Login</h1>

<?php $form = \app\includes\form\Form::begin('', "post") ?>
<?= $form->field($rule, 'email') ?>
<?= $form->field($rule, 'password')->passwordField() ?>

<button type="submit" class="btn btn-primary">Submit</button>
<?= \app\includes\form\Form::end() ?>