<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \panix\mod\rbac\models\BizRuleModel */

$this->title = Yii::t('rbac/default', 'Update Rule : {0}', $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/default', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('rbac/default', 'Update');

?>

<div class="rule-item-update">
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-header">
                    <h5><?php echo Html::encode($this->title); ?></h5>
                </div>
                <div class="card-body">

                    <?php echo $this->render('_form', [
                        'model' => $model,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            dsadsadsa
        </div>
    </div>
</div>