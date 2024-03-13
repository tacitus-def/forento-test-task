<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'sex',
            'email:email',
            'status_id',
        ],
    ]) ?>

    <h3>Clients</h3>
    <?= Html::beginForm(Url::to(['user/add-client', 'id' => $model->id]), 'POST', ['class' => 'row g-3']) ?>
    <div class="col-auto">
        <label class="col-form-label">Name</label>
    </div>
    <div class="col-auto">
    <?= Html::textInput('name', '', ['class' =>'form-control']) ?>
    </div>
    <div class="col-auto">
    <?= Html::submitButton('Add', ['class' =>'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
    <?= GridView::widget([
        'dataProvider' => $clientProvider,
        'columns' => [
            'name',
            [
                'class' => ActionColumn::class,
                'template' => '{delete}',
                'urlCreator' => function ($action, $client) use ($model) {
                    return Url::to(["user/" . $action . "-client", 'id' => $model->id, 'client' => $client->id]);
                }
            ]
        ]
    ]) ?>

</div>
