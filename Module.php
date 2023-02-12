<?php

namespace panix\mod\rbac;

use app\web\themes\dashboard\sidebar\BackendNav;
use Yii;
use panix\engine\WebModule;

/**
 * GUI manager for RBAC.
 *
 * Use [[\yii\base\Module::$controllerMap]] to change property of controller.
 *
 * ```php
 * 'controllerMap' => [
 *     'assignment' => [
 *         'class' => 'panix\mod\rbac\controllers\AssignmentController',
 *         'userIdentityClass' => 'app\models\User',
 *         'searchClass' => [
 *              'class' => 'panix\mod\rbac\models\search\AssignmentSearch',
 *              'pageSize' => 10,
 *         ],
 *         'idField' => 'id',
 *         'usernameField' => 'username'
 *         'gridViewColumns' => [
 *              'id',
 *              'username',
 *              'email'
 *         ],
 *     ],
 * ],
 * ```php
 */
class Module extends WebModule
{

    public $icon = '';
    /**
     * @var string the default route of this module. Defaults to 'default'
     */
    public $defaultRoute = 'assignment';

    public function getAdminMenu()
    {
        return [
            'user' => [
                'items' => [
                    [
                        'label' => Yii::t('rbac/default', 'MODULE_NAME'),
                        'url' => '#',
                        'icon' => $this->icon,
                        'visible' => Yii::$app->user->can('/rbac/admin/assignment/index') || Yii::$app->user->can('/rbac/admin/assignment/*'),
                        'items' => [
                            [
                                'label' => Yii::t('rbac/default', 'ASSIGNMENTS'),
                                'url' => ['/admin/rbac/assignment/index'],
                                'visible' => Yii::$app->user->can('/rbac/admin/assignment/index') || Yii::$app->user->can('/rbac/admin/assignment/*'),
                            ],
                            [
                                'label' => Yii::t('rbac/default', 'ROLES'),
                                'url' => ['/admin/rbac/role/index'],
                                'visible' => Yii::$app->user->can('/rbac/admin/role/index') || Yii::$app->user->can('/rbac/admin/role/*'),
                            ],
                            [
                                'label' => Yii::t('rbac/default', 'PERMISSIONS'),
                                'url' => ['/admin/rbac/permission/index'],
                                'visible' => Yii::$app->user->can('/rbac/admin/permission/index') || Yii::$app->user->can('/rbac/admin/permission/*'),
                            ],
                            [
                                'label' => Yii::t('rbac/default', 'ROUTES'),
                                'url' => ['/admin/rbac/route/index'],
                                'visible' => Yii::$app->user->can('/rbac/admin/route/index') || Yii::$app->user->can('/rbac/admin/route/*'),
                            ],
                            [
                                'label' => Yii::t('rbac/default', 'RULES'),
                                'url' => ['/admin/rbac/rule/index'],
                                'visible' => Yii::$app->user->can('/rbac/admin/rule/index') || Yii::$app->user->can('/rbac/admin/rule/*'),
                            ],
                        ]
                    ],
                ],
            ],
        ];
    }

    public function getAdminSidebar()
    {
        return Yii::$app->findMenu['system']['items'];
    }
}
