<?php

use app\models\Like;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Likes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="like-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Like', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idlike',
            'iduser',
            'idarticle',
            'is_like:boolean',
            'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Like $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idlike' => $model->idlike]);
                 }
            ],
        ],
    ]); ?>


</div>
