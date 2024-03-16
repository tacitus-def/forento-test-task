<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\PersonSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Create
            </button>
            <ul class="dropdown-menu">
                <li><?= Html::a('Create User', ['create-user'], ['class' => 'dropdown-item']) ?></li>
                <li><?= Html::a('Create Group', ['create-group'], ['class' => 'dropdown-item']) ?></li>
            </ul>
        </div>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => ['class' => \backend\components\FormatterUser::class],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'type_is:type',
            'sex:sex',
            'email:email',
            'status_id:status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    if ($action == 'update') {
                        $type = '';
                        switch ($model->type_is) {
                            case User::TYPE_GROUP:
                                $type = 'group';
                                break;
                            case User::TYPE_PERSON:
                                $type = 'user';
                                break;
                        }
                        return Url::toRoute(["{$action}-{$type}", 'id' => $model->id]);
                    }
                    else {
                        return Url::toRoute([$action, 'id' => $model->id]);
                     }
                 }
            ],
        ],
    ]); ?>


</div>
