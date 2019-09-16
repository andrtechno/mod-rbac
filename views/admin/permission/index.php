<?php

use panix\engine\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $searchModel \panix\mod\rbac\models\search\AuthItemSearch */

Pjax::begin(['timeout' => 5000, 'enablePushState' => false]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'name',
            'label' => Yii::t('rbac/default', 'NAME'),
        ],
        [
            'attribute' => 'ruleName',
            'label' => Yii::t('rbac/default', 'RULE_NAME'),
            'filter' => ArrayHelper::map(Yii::$app->getAuthManager()->getRules(), 'name', 'name'),
            'filterInputOptions' => ['class' => 'form-control', 'prompt' => Yii::t('rbac/default', 'SELECT_RULE')],
        ],
        [
            'attribute' => 'description',
            'format' => 'ntext',
            'label' => Yii::t('rbac/default', 'DESCRIPTION'),
        ],
        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
        ],
    ],
]);

Pjax::end();
