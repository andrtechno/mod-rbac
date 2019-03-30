<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \panix\mod\rbac\models\BizRuleModel */
/* @var $form ActiveForm */
?>
<div class="row">
    <div class="col-md-6">
        <div class="card bg-light">
            <div class="card-body">


                <div class="rule-item-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?php echo $form->field($model, 'name')->textInput(['maxlength' => 64]); ?>

                    <?php echo $form->field($model, 'className')->textInput(); ?>

                    <div class="form-group">
                        <?php echo Html::submitButton(
                            $model->getIsNewRecord() ? Yii::t('rbac/default', 'Create') : Yii::t('rbac/default', 'Update'),
                            [
                                'class' => $model->getIsNewRecord() ? 'btn btn-success' : 'btn btn-primary',
                            ]
                        ); ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        dsadsadsa
    </div>
</div>