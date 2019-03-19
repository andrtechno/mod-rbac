<?php

use yii\helpers\Html;

/* @var $this  yii\web\View */
/* @var $model \panix\mod\rbac\models\BizRuleModel */

$this->title = Yii::t('rbac/default', 'Create Rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/default', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo $this->render('../layouts/_sidebar');
?>
<div class="rule-item-create">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>