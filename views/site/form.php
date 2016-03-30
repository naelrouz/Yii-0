<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php if($name){?>
<h1>Имя: <?=$name?> </h1>
<h1>E-mail: <?=$name?> </h1>
<?php } ?>

<?php 
$f = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); 
?>
    <?=$f->field($form, 'name')?>
    <?=$f->field($form , 'email')?>
    <?=$f->field($form , 'file')->fileInput()?>
    <?=Html::submitButton('Отправить');?>
<?php ActiveForm::end(); ?>