<?php

/* @var $this \yii\web\View */

$this->params['sidebar'] = [
    [
        'label' => Yii::t('rbac/default', 'Assignments'),
        'url' => ['assignment/index'],
    ],
    [
        'label' => Yii::t('rbac/default', 'Roles'),
        'url' => ['role/index'],
    ],
    [
        'label' => Yii::t('rbac/default', 'Permissions'),
        'url' => ['permission/index'],
    ],
    [
        'label' => Yii::t('rbac/default', 'Routes'),
        'url' => ['route/index'],
    ],
    [
        'label' => Yii::t('rbac/default', 'Rules'),
        'url' => ['rule/index'],
    ],
];

echo \yii\widgets\Menu::widget([
    'items' => $this->params['sidebar'],
]);
?>
