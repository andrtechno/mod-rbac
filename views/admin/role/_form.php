<?php

use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model panix\mod\rbac\models\AuthItemModel */
?>

<?php
\panix\engine\CMS::dump($model->getItemsByBackend()['assigned']);


$test=[];
$test=[
    'backend'=>[
        '/admin/admin/ajax/*',
        '/admin/admin/ajax/autocomplete'
    ],
    'frontend'=>[
        '/asset/compress'
    ],
];

\panix\engine\CMS::dump($test);

?>
<?php $form = ActiveForm::begin(); ?>

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
        $model->items = $model->getItemsByBackend()['assigned'];

        echo $form->field($model, 'items')->dropDownList($test2['available']);
       /* echo $form->field($model, 'items')->widget(\panix\ext\bootstrapselect\BootstrapSelect::class,[

           // 'value' => $test,//array_keys($test2['assigned']),
            'items' => $test2['available'],
            'options' => [
                'multiple' => true
            ],
            'jsOptions' => [
                'width' => '100%',
                'liveSearch' => true,
                'dropupAuto' => false,
                'dropdownAlignRight' => false
            ]
        ]); */?>


    </div>
</div>
<?php

/*
echo \panix\ext\bootstrapselect\BootstrapSelect::widget([
    'name' => 'items2',
   'value' => $test,//array_keys($test2['assigned']),
    'items' => $test2['available'],
    'options' => [
        'multiple' => true
    ],
    'jsOptions' => [
        'width' => '100%',
        'liveSearch' => true,
        'dropupAuto' => false,
        'dropdownAlignRight' => false
    ]
]);*/
?>
<div class="card-footer text-center">
    <?= Html::submitButton($model->getIsNewRecord() ? Yii::t('app', 'CREATE') : Yii::t('app', 'UPDATE'), ['class' => $model->getIsNewRecord() ? 'btn btn-success' : 'btn btn-primary']); ?>
</div>

<?php ActiveForm::end(); ?>

