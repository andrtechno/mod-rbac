<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \panix\mod\rbac\models\BizRuleModel */

$this->title = Yii::t('rbac/default', 'Rule : {0}', $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/default', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;

?>
<div class="rule-item-view">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p>
        <?php echo Html::a(Yii::t('rbac/default', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']); ?>
        <?php echo Html::a(Yii::t('rbac/default', 'Delete'), ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data-confirm' => Yii::t('rbac/default', 'Are you sure to delete this item?'),
            'data-method' => 'post',
        ]); ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'className',
        ],
    ]); ?>

</div>
