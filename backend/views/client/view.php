<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var common\models\Client $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-view">

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
        'formatter' => ['class' => \backend\components\FormatterClient::class],
        'attributes' => [
            'name',
            'description:ntext',
            'account_type:accountType',
            'balance',
            'status:status',
        ],
    ]) ?>

    <h3>Users</h3>
    <?= Html::beginForm(Url::to(['client/add-user', 'id' => $model->id]), 'POST', ['class' => 'row g-3']) ?>
    <div class="col-auto">
        <label class="col-form-label">Email</label>
    </div>
    <div class="col-auto">
    <?= Html::textInput('email', '', ['class' =>'form-control']) ?>
    </div>
    <div class="col-auto">
    <?= Html::submitButton('Add', ['class' =>'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
    <?= GridView::widget([
        'dataProvider' => $userProvider,
        'columns' => [
            'name',
            'email:email',
            [
                'class' => ActionColumn::class,
                'template' => '{delete}',
                'urlCreator' => function ($action, $user) use ($model) {
                    return Url::to(["client/" . $action . "-user", 'id' => $model->id, 'user' => $user->id]);
                }
            ]
        ]
    ]) ?>

</div>
