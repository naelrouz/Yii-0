<?php
use yii\widgets\LinkPager;
?>

<h1>Коментарии</h1>
<b> Последний раз смотрели профиль: <?=$name?></b><br><br>
<ul>
<?php foreach ($comments as $comments) { ?>
    <li><b><a href="<?= Yii::$app->urlManager->createUrl(['site/user', 'name'=>$comments->name])?>"><?=$comments->name?> </a></b>: <?=$comments->text?></li>    
<?php } ?>
</ul>
<?= LinkPager::widget(['pagination' => $pagination]) ?>