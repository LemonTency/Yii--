<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Books */
/* @var $form yii\widgets\ActiveForm */
?>

<div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <!-- 没错，只要一行。 一行一条目，因为field自动帮你打包了（1个默认label，1个默认input，1个默认error提示）。 你需要提供的参数也就是 1.我们从action推进来的 comments model。 2.model 中的属性(对应表中的字段)。 label从哪里读出来的？Comments model 中的 attributeLabels。 error显示的规则哪里来的？Comments model 中的 rules 规则验证。 field($model,'xxx') -->
</div>
