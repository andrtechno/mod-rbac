<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $gridViewColumns array */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $searchModel \panix\mod\rbac\models\search\AssignmentSearch */

?>
<div class="assignment-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php Pjax::begin(['timeout' => 5000]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => ArrayHelper::merge($gridViewColumns, [
            [
                'class' => 'panix\engine\grid\columns\ActionColumn',
                'template' => '{view}',
            ],
        ]),
    ]); ?>

    <?php Pjax::end(); ?>
</div>
