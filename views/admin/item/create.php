<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \panix\mod\rbac\models\AuthItemModel */

$labels = $this->context->getLabels();
$this->title = Yii::t('rbac/default', 'Create ' . $labels['Item']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/default', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="auth-item-create">
    <h1><?php echo Html::encode($this->title); ?></h1>
    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>