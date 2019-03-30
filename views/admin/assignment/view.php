<?php

use yii\helpers\Html;
use yii\helpers\Json;
use panix\mod\rbac\RbacAsset;

RbacAsset::register($this);

/* @var $this yii\web\View */
/* @var $model \panix\mod\rbac\models\AssignmentModel */

?>
<div class="assignment-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php echo $this->render('../_dualListBox', [
        'opts' => Json::htmlEncode([
            'items' => $model->getItems(),
        ]),
        'assignUrl' => ['/admin/rbac/test2/assign', 'id' => $model->userId],
        'removeUrl' => ['/admin/rbac/test2/remove', 'id' => $model->userId],
    ]); ?>

</div>
