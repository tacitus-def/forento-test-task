<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Person $model */

$this->title = 'Update User: ' . $form->model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $form->model->name, 'url' => ['view', 'id' => $form->model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-user', [
        'model' => $form,
    ]) ?>

</div>
