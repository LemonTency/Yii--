<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<h1><?=Html::encode($view_hello_data);?></h1>
<h1><?=HtmlPurifier::process($view_hello_data);?></h1>
