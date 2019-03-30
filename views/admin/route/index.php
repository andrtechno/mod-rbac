<?php

use yii\helpers\Html;
use yii\helpers\Json;
use panix\mod\rbac\RbacRouteAsset;

RbacRouteAsset::register($this);

/* @var $this yii\web\View */
/* @var $routes array */

$this->title = Yii::t('rbac/default', 'Routes');
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?php echo Html::encode($this->title); ?></h1>
<?php echo Html::a(Yii::t('rbac/default', 'Refresh'), ['/admin/rbac/route/refresh'], [
    'class' => 'btn btn-primary',
    'id' => 'btn-refresh',
]); ?>
<?php echo $this->render('../_dualListBox', [
    'opts' => Json::htmlEncode([
        'items' => $routes,
    ]),
    'assignUrl' => ['/admin/rbac/route/assign'],
    'removeUrl' => ['/admin/rbac/route/remove'],
]); ?>
