<?php

use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model panix\mod\rbac\models\AuthItemModel */


$items = $model->getItemsDropDown();


$form = ActiveForm::begin();
?>

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


        <?php
      //  $model->items = array_keys($model->getItems()['assigned']);
        $model->items = $items['assigned'];
        echo $form->field($model, 'items')->widget(\panix\ext\bootstrapselect\BootstrapSelect::class, [
            'items' => $items['available'],
            'options' => [
                'multiple' => true
            ],
            'jsOptions' => [
                'width' => '100%',
                'liveSearch' => true,
                'dropupAuto' => false,
                'dropdownAlignRight' => false,
                'size'=>'10'
            ]
        ]); ?>


    </div>
</div>

<div class="card-footer text-center">
    <?= Html::submitButton($model->getIsNewRecord() ? Yii::t('app/default', 'CREATE') : Yii::t('app/default', 'UPDATE'), ['class' => $model->getIsNewRecord() ? 'btn btn-success' : 'btn btn-primary']); ?>
</div>

<?php ActiveForm::end(); ?>

