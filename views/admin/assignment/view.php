<?php

use panix\engine\Html;
use yii\helpers\Json;
use panix\mod\rbac\RbacAsset;
use yii\web\View;
use panix\ext\select2\Select2;

RbacAsset::register($this);

/* @var $this yii\web\View */
/* @var $model \panix\mod\rbac\models\AssignmentModel */


$modelClass = Yii::createObject(\panix\mod\rbac\models\RouteModel::class);

$test2 = \panix\mod\rbac\models\AuthItemModel::find('admin')->getItemsDropDown();

$items = [];
foreach ($modelClass->getAvailableAndAssignedRoutes()['assigned'] as $k => $item) {
    $items[$item] = $item;
}


/*
echo Select2::widget([
    'name' => 'items',
    'value' => array_keys($test2['assigned']),
    'items' => $test2['available'],
    'options' => [
        'multiple' => true
    ],
    'clientOptions' => [
        'width' => '100%',
        'liveSearch' => true,
        //'dropupAuto' => false,
        //'dropdownAlignRight' => false
    ]
]);*/
$opts = Json::htmlEncode([
    'items' => $model->getItems(),
]);
?>

<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName; ?></h5>
    </div>
    <div class="card-body p-3">
        <div class="assignment-index">

            <?php

            /* @var $this yii\web\View */
            /* @var $assignUrl array */
            /* @var $removeUrl array */
            /* @var $opts string */

            $this->registerJs("var _opts = {$opts};", View::POS_BEGIN);
            ?>
            <div class="row">
                <div class="col-lg-5">
                    <input class="form-control search" data-target="available"
                           placeholder="<?php echo Yii::t('rbac/default', 'SEARCH_AVAILABLE'); ?>">
                    <br/>
                    <select multiple size="20" class="form-control list" data-target="available"></select>
                </div>
                <div class="col-lg-2 col-lg-2 d-flex align-items-center justify-content-center">
                    <?php /*echo Html::a(Yii::t('rbac/default', 'REFRESH'), ['/admin/rbac/route/refresh'], [
                'class' => 'btn btn-primary',
                'id' => 'btn-refresh',
            ]);*/ ?>
                    <div class="move-buttons ">


                        <?php echo Html::a(Html::icon('arrow-left').' Удалить', ['/admin/rbac/assignment/remove', 'id' => $model->userId], [
                            'class' => 'btn btn-sm btn-danger btn-assign',
                            'data-target' => 'assigned',
                            'title' => Yii::t('app/default', 'DELETE'),
                        ]); ?>
                        <?php echo Html::a(Html::icon('arrow-right').' Добавить', ['/admin/rbac/assignment/assign', 'id' => $model->userId], [
                            'class' => 'btn btn-sm btn-success btn-assign',
                            'data-target' => 'available',
                            'title' => Yii::t('rbac/default', 'Assign'),
                        ]); ?>
                    </div>
                </div>
                <div class="col-lg-5">
                    <input class="form-control search" data-target="assigned"
                           placeholder="<?php echo Yii::t('rbac/default', 'SEARCH_ASSIGNED'); ?>">
                    <br/>
                    <select multiple size="20" class="form-control list" data-target="assigned"></select>
                </div>
            </div>
        </div>
    </div>
</div>
