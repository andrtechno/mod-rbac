<?php

use panix\engine\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $searchModel \panix\mod\rbac\models\search\AuthItemSearch */

$labels = $this->context->getLabels();
$this->context->pageName = Yii::t('rbac/default', $labels['Items']);
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="item-index">

    <p>
        <?php echo Html::a(Yii::t('rbac/default', 'Create ' . $labels['Item']), ['create'], ['class' => 'btn btn-success']); ?>
    </p>
    <?php Pjax::begin(['timeout' => 5000, 'enablePushState' => false]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => Yii::t('rbac/default', 'Name'),
            ],
            [
                'attribute' => 'ruleName',
                'label' => Yii::t('rbac/default', 'Rule Name'),
                'filter' => ArrayHelper::map(Yii::$app->getAuthManager()->getRules(), 'name', 'name'),
                'filterInputOptions' => ['class' => 'form-control', 'prompt' => Yii::t('rbac/default', 'Select Rule')],
            ],
            [
                'attribute' => 'description',
                'format' => 'ntext',
                'label' => Yii::t('rbac/default', 'Description'),
            ],
            [
                'header' => Yii::t('rbac/default', 'Action'),
                'class' => 'panix\engine\grid\columns\ActionColumn',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>