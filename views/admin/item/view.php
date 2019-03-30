<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\DetailView;
use panix\mod\rbac\RbacAsset;

RbacAsset::register($this);

/* @var $this yii\web\View */
/* @var $model \panix\mod\rbac\models\AuthItemModel */

$labels = $this->context->getLabels();
$this->title = Yii::t('rbac/default', $labels['Item'] . ' : {0}', $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/default', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;

?>
<div class="auth-item-view">
    <h1><?php echo Html::encode($this->title); ?></h1>
    <p>
        <?php echo Html::a(Yii::t('rbac/default', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']); ?>
        <?php echo Html::a(Yii::t('rbac/default', 'Delete'), ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data-confirm' => Yii::t('rbac/default', 'Are you sure to delete this item?'),
            'data-method' => 'post',
        ]); ?>
        <?php echo Html::a(Yii::t('rbac/default', 'Create'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>
    <div class="row">
        <div class="col-sm-12">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'description:ntext',
                    'ruleName',
                    'data:ntext',
                ],
            ]); ?>
        </div>
    </div>
    <?php echo $this->render('../_dualListBox', [
        'opts' => Json::htmlEncode([
            'items' => $model->getItems(),
        ]),
        'assignUrl' => ['/admin/rbac/test/assign', 'id' => $model->name],
        'removeUrl' => ['/admin/rbac/test/remove', 'id' => $model->name],
    ]); ?>
</div>
