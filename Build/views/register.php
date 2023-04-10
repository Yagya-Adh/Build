<h1 class="mb-3">Create an account</h1>

<!--   Form::beign($action, $method)  -->

<?php $form = \app\core\form\Form::begin('', "post") ?>

<div class="row">
    <div class="col">
        <?php echo $form->field($model, 'firstname')  ?>
    </div>
    <div class="col">
        <?php echo $form->field($model, 'lastname')  ?>
    </div>
</div>

<?php echo $form->field($model, 'email')  ?>
<?php echo $form->field($model, 'password')->passwordField()  ?>
<?php echo $form->field($model, 'confirmPassword')->passwordField()  ?>
<button type="submit" class="btn btn-primary mt-3">Submit</button>

<?php echo \app\core\form\Form::end() ?>