<?php

use common\models\Client;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Client $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'description')->textInput() ?>
    <?= $form->field($model, 'balance')->textInput() ?>
    <?= $form->field($model, 'account_type')->dropDownList([
            Client::TYPE_PRIVATE => 'Private', 
            Client::TYPE_PUBLIC => 'Public', 
            Client::TYPE_LIMITED => 'Limited'], [
                'prompt' => '— Select —'
            ]) ?>
    <?= $form->field($model, 'status')->dropDownList([
            Client::STATUS_INACTIVE => 'Inactive',
            Client::STATUS_ACTIVE => 'Active'], [
                'prompt' => '— Select —'
            ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
