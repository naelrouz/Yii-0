<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $f = ActiveForm::begin(); ?>
<?=$f->field($form,'name')?>
<?=$f->field($form,'email')?>
<?=Html::submitButton('Отправить');?>
<?php ActiveForm::end(); ?>