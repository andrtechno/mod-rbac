<?php

use yii\helpers\Html;
use yii\helpers\Json;
use panix\mod\rbac\RbacRouteAsset;

RbacRouteAsset::register($this);

/* @var $this yii\web\View */
/* @var $routes array */


?>
<div class="card">
    <div class="card-header">
        <h5><?php echo Html::encode($this->context->pageName); ?></h5>
    </div>
    <div class="card-body">
        <div class="col">

            <?php echo $this->render('../_dualListBox', [
                'opts' => Json::htmlEncode([
                    'items' => $routes,
                ]),
                'assignUrl' => ['/admin/rbac/route/assign'],
                'removeUrl' => ['/admin/rbac/route/remove'],
            ]); ?>
        </div>
    </div>
</div>