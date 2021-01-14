<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model panix\mod\rbac\models\AuthItemModel */


$items = $model->getItemsDropDown();
$opts = \yii\helpers\Json::htmlEncode([
    'items' => (new \panix\mod\rbac\models\RouteModel())->getAvailableAndAssignedRoutes(),
]);
$this->registerJs("var _opts = {$opts};", \yii\web\View::POS_BEGIN);
$form = ActiveForm::begin();
?>

<div class="card-body ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
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
            <div class="col-md-6">


                <input class="form-control search" data-target="assigned"
                       placeholder="<?= Yii::t('rbac/default', 'SEARCH_AVAILABLE'); ?>">


                <?php
                // $model->items = array_keys($model->getItems()['assigned']);
                $model->items = $items['assigned'];
                //unset($items['available']['Роли']);
                //  \panix\engine\CMS::dump($items['available']);
                /*echo $form->field($model, 'items')->widget(\panix\ext\bootstrapselect\BootstrapSelect::class, [
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
                ]);*/
                unset($items['available']['frontend']);
                echo $form->field($model, 'items')->dropdownList($items['available'], [
                    'multiple' => true,
                    'class' => 'form-control list',
                    'size' => '20',
                    'data-target' => "assigned"
                ]);


                ?>
            </div>
        </div>
    </div>
</div>


<div class="card-footer text-center">
    <?= Html::submitButton($model->getIsNewRecord() ? Yii::t('app/default', 'CREATE') : Yii::t('app/default', 'UPDATE'), ['class' => $model->getIsNewRecord() ? 'btn btn-success' : 'btn btn-primary']); ?>
</div>

<?php ActiveForm::end(); ?>

