<?php

use panix\engine\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $assignUrl array */
/* @var $removeUrl array */
/* @var $opts string */

$this->registerJs("var _opts = {$opts};", View::POS_BEGIN);
?>
<div class="row mt-3 mb-3">
    <div class="col-lg-5">
        <h5 class="text-center mt-3 mb-3"><?= Yii::t('rbac/default', 'AVAILABLE'); ?></h5>
        <input class="form-control search" data-target="available"
               placeholder="<?= Yii::t('rbac/default', 'SEARCH_AVAILABLE'); ?>">
        <br/>
        <select multiple size="20" class="form-control list" data-target="available"></select>
    </div>
    <div class="col-lg-2">
        <div class="text-center">
            <?php echo Html::a(Yii::t('rbac/default', 'REFRESH'), ['/admin/rbac/route/refresh'], [
                'class' => 'btn btn-primary mt-3',
                'id' => 'btn-refresh',
            ]); ?>

            <div class="mt-3">


                <?php echo Html::a(Html::icon('double-arrow-left'), $removeUrl, [
                    'class' => 'btn btn-danger btn-assign',
                    'data-target' => 'assigned',
                    'title' => Yii::t('app/default', 'DELETE'),
                ]); ?>
                <?php echo Html::a(Html::icon('double-arrow-right'), $assignUrl, [
                    'class' => 'btn btn-success btn-assign',
                    'data-target' => 'available',
                    'title' => Yii::t('rbac/default', 'Assign'),
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <h5 class="text-center mt-3 mb-3"><?= Yii::t('rbac/default', 'ASSIGNED'); ?></h5>
        <input class="form-control search" data-target="assigned"
               placeholder="<?php echo Yii::t('rbac/default', 'SEARCH_ASSIGNED'); ?>">
        <br/>
        <select multiple size="20" class="form-control list" data-target="assigned"></select>
    </div>
</div>