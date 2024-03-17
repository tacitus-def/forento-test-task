<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\helpers\Url;
use yii\bootstrap5\Html;

$this->title = 'Select Group';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?= Html::beginForm(['login-group']); ?>

            <p><?= Html::a('Skip selection group', Url::to(['site/index'])) ?></p>
            <div class="form-group">
                <?= Html::dropDownList('group', '', $groups, ['prompt' => '— Select Group —', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Enter', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?= Html::endForm(); ?>
        </div>
    </div>
</div>
