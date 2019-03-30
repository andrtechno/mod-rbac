<?php

use yii\helpers\Html;
use panix\mod\rbac\RbacAsset;

$modelClass = Yii::createObject(\panix\mod\rbac\models\RouteModel::class);

$test = new \panix\mod\rbac\models\AssignmentModel(\mdm\admin\models\User::findOne(Yii::$app->user->id), []);


$test2 = \panix\mod\rbac\models\AuthItemModel::find('admin')->getItems();

print_r(array_keys($test2['assigned']));
//echo \yii\helpers\VarDumper::dump($test->getItems(),10,true);

RbacAsset::register($this);
/* @var $this yii\web\View */
/* @var $model \panix\mod\rbac\models\AuthItemModel */


$context = $this->context;
$labels = $this->context->getLabels();
$this->title = Yii::t('rbac/default', 'Update ' . $labels['Item'] . ' : {0}', $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac/default', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('rbac/default', 'Update');

$items = [];
foreach ($modelClass->getAvailableAndAssignedRoutes()['assigned'] as $item) {
    $items[$item] = $item;
}


?>

<div class="auth-item-update">
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

            <?php

            echo \panix\ext\bootstrapselect\BootstrapSelect::widget([
                'name' => 'items',
                'value' => array_keys($test2['assigned']),
                'items' => $items,
                'options' => [
                    'multiple' => true
                ],
                'jsOptions' => [
                    'liveSearch' => true,
                    'dropupAuto' => false,
                    'dropdownAlignRight' => 'auto'
                ]
            ]);

            echo Html::dropDownList('items2', array_keys($test2['assigned']), $items, [
                'class' => 'form-control',
                // 'data-target' => 'assigned',
                'id' => 'item',
                'data->id' => Yii::$app->request->get('id'),
                'multiple' => true
            ]);

            //print_r($model->getAvailableAndAssignedRoutes()['assigned']);
            ?>
            <a href="/admin/rbac/role/assign?id=<?= Yii::$app->request->get('id') ?>" data-target="#item"
               class="btn-assign2">ok</a>
        </div>
    </div>

</div>