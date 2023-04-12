<?php

/** @var  $this \app\core\view  */
/** @var  $model \app\models\ContactForm  */

use app\core\form\TextareaField;

$this->title = 'Contact';
?>

<h1>Contact us</h1>


<?php $form = \app\core\form\Form::begin('', 'post') ?>

<?php echo $form->field($model, 'subject') ?>
<?php echo $form->field($model, 'email') ?>
<?php echo new TextareaField($model, 'body') ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php \app\core\form\Form::end(); ?>





<!--  add couple of things.
       we can have select ,radio, checkbox so on practice more ...
-->