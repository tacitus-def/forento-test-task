<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Group $model */

$this->title = 'Create Group';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-group', [
        'model' => $form,
    ]) ?>

</div>
