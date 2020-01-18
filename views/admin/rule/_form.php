<?php

use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \panix\mod\rbac\models\BizRuleModel */
/* @var $form ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="rule-item-form">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => 64]); ?>
                        <?= $form->field($model, 'className')->textInput(); ?>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <?= Html::submitButton(
                        Yii::t('app/default', $model->getIsNewRecord() ? 'CREATE' : 'UPDATE'),
                        [
                            'class' => $model->getIsNewRecord() ? 'btn btn-success' : 'btn btn-primary',
                        ]
                    ); ?>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>