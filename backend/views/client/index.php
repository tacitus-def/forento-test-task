<?php

use common\models\Client;
use yii\helpers\Html;
use yii\bootstrap5\Html as Html5;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use backend\components\ClientLabels;

/** @var yii\web\View $this */
/** @var backend\models\ClientSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'formatter' => ['class' => \backend\components\ClientFormatter::class],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'description:ntext',
            [
                'attribute' => 'account_type',
                'format' => 'accountType',
                'filter' => Html5::activeDropDownList(
                        $searchModel,
                        'account_type',
                        ClientLabels::getAccountTypeList(), [
                            'class' => 'form-control',
                            'prompt' => '— Select —',
                        ]),
            ],
            'balance',
            [
                'attribute' => 'status',
                'format' => 'status',
                'filter' => Html5::activeDropDownList(
                        $searchModel,
                        'status',
                        ClientLabels::getStatusList(), [
                            'class' => 'form-control',
                            'prompt' => '— Select —',
                        ]),
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Client $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
