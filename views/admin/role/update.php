<?php

use yii\helpers\Html;
use panix\mod\rbac\RbacAsset;
use panix\mod\rbac\models\AuthItemModel;

$modelClass = Yii::createObject(\panix\mod\rbac\models\RouteModel::class);





//print_r($test2['assigned']);


RbacAsset::register($this);
/* @var $this yii\web\View */
/* @var $model AuthItemModel */


$items = [];
foreach ($modelClass->getAvailableAndAssignedRoutes()['assigned'] as $k=>$item) {
    $items[$item] = $item;
}


//\panix\engine\CMS::dump($model->getItems());die;

?>

<div class="auth-item-update">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo Html::encode($this->context->pageName); ?></h5>
                </div>


                    <?php echo $this->render('_form', [
                        'model' => $model,
                    ]); ?>

            </div>
        </div>
        <div class="col-md-6">

            <?php



            /* echo Html::dropDownList('items2', array_keys($test2['assigned']), $items, [
                 'class' => 'form-control',
                 // 'data-target' => 'assigned',
                 'id' => 'item',
                 'data->id' => Yii::$app->request->get('id'),
                 'multiple' => true
             ]);*/

            //print_r($model->getAvailableAndAssignedRoutes()['assigned']);
            ?>
            <a href="/admin/rbac/role/assign?id=<?= Yii::$app->request->get('id') ?>" data-target="#item"
               class="btn-assign2">ok</a>
        </div>
    </div>

</div>