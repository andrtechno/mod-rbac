<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \panix\mod\rbac\models\AuthItemModel */

?>

<div class="card">
    <div class="card-header">
        <h5><?php echo Html::encode($this->context->pageName); ?></h5>
    </div>

    <div class="auth-item-create">
        <h1><?php echo Html::encode($this->title); ?></h1>
        <?php echo $this->render('_form', [
            'model' => $model,
        ]); ?>
    </div>

</div>


