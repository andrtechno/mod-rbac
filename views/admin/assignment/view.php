<?php

use panix\engine\Html;
use yii\helpers\Json;
use panix\mod\rbac\RbacAsset;
use yii\web\View;

RbacAsset::register($this);

/* @var $this yii\web\View */
/* @var $model \panix\mod\rbac\models\AssignmentModel */



$modelClass = Yii::createObject(\panix\mod\rbac\models\RouteModel::class);

$test2 = \panix\mod\rbac\models\AuthItemModel::find('admin')->getItemsDropDown();

$items = [];
foreach ($modelClass->getAvailableAndAssignedRoutes()['assigned'] as $k=>$item) {
    $items[$item] = $item;
}



echo \panix\ext\bootstrapselect\BootstrapSelect::widget([
    'name' => 'items',
    'value' => array_keys($test2['assigned']),
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
]);
$opts=Json::htmlEncode([
    'items' => $model->getItems(),
]);
?>
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
                   placeholder="<?php echo Yii::t('rbac/default', 'Search for available'); ?>">
            <br/>
            <select multiple size="20" class="form-control list" data-target="available"></select>
        </div>
        <div class="col-lg-2">
            <?php echo Html::a(Yii::t('rbac/default', 'REFRESH'), ['/admin/rbac/route/refresh'], [
                'class' => 'btn btn-primary',
                'id' => 'btn-refresh',
            ]); ?>
            <div class="move-buttons">
                <br><br>
                <?php echo Html::a('&gt;&gt;', ['/admin/rbac/assignment/assign', 'id' => $model->userId], [
                    'class' => 'btn btn-success btn-assign',
                    'data-target' => 'available',
                    'title' => Yii::t('rbac/default', 'Assign'),
                ]); ?>
                <br/><br/>
                <?php echo Html::a('&lt;&lt;', ['/admin/rbac/assignment/remove', 'id' => $model->userId], [
                    'class' => 'btn btn-danger btn-assign',
                    'data-target' => 'assigned',
                    'title' => Yii::t('rbac/default', 'Remove'),
                ]); ?>
            </div>
        </div>
        <div class="col-lg-5">
            <input class="form-control search" data-target="assigned"
                   placeholder="<?php echo Yii::t('rbac/default', 'Search for assigned'); ?>">
            <br/>
            <select multiple size="20" class="form-control list" data-target="assigned"></select>
        </div>
</div>
