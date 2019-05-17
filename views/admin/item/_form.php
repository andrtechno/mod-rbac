<?php

use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model panix\mod\rbac\models\AuthItemModel */
?>

<?php

?>
<?php $form = ActiveForm::begin(); ?>
<div class="card">
    <div class="card-body">
        <div class="auth-item-form">

            <?= $form->field($model, 'name')->textInput(['maxlength' => 64]); ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 2]); ?>
            <?= $form->field($model, 'ruleName')->widget('yii\jui\AutoComplete', [
                'options' => [
                    'class' => 'form-control',
                ],
                'clientOptions' => [
                    'source' => array_keys(Yii::$app->authManager->getRules()),
                ],
            ]);
            ?>
            <?= $form->field($model, 'data')->textarea(['rows' => 6]); ?>
        </div>
    </div>
    <div class="card-footer text-center">
        <?= Html::submitButton($model->getIsNewRecord() ? Yii::t('rbac/default', 'Create') : Yii::t('rbac/default', 'Update'), ['class' => $model->getIsNewRecord() ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

