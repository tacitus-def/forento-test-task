<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Group $model */

$this->title = 'Update Group: ' . $form->model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $form->model->name, 'url' => ['view', 'id' => $form->model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-group', [
        'model' => $form,
    ]) ?>

</div>
