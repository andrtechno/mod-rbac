<?php

namespace panix\mod\rbac;

use panix\mod\admin\widgets\sidebar\BackendNav;
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

    /**
     * @var string the namespace that controller classes are in
     */
     //public $controllerNamespace = 'panix\mod\rbac\admin\controllers';


    public function getAdminMenu()
    {
        return [
            'system' => [
                'items' => [
                    [
                        'label' => Yii::t('rbac/default', 'MODULE_NAME'),
                        'url' => '#',
                        'icon' => $this->icon,
                        'items' => [
                            [
                                'label' => Yii::t('rbac/default', 'ASSIGNMENTS'),
                                'url' => ['/admin/rbac/assignment/index'],
                            ],
                            [
                                'label' => Yii::t('rbac/default', 'ROLES'),
                                'url' => ['/admin/rbac/role/index'],
                            ],
                            [
                                'label' => Yii::t('rbac/default', 'PERMISSIONS'),
                                'url' => ['/admin/rbac/permission/index'],
                            ],
                            [
                                'label' => Yii::t('rbac/default', 'ROUTES'),
                                'url' => ['/admin/rbac/route/index'],
                            ],
                            [
                                'label' => Yii::t('rbac/default', 'RULES'),
                                'url' => ['/admin/rbac/rule/index'],
                            ],
                        ]
                    ],
                ],
            ],
        ];
    }

    public function getAdminSidebar()
    {
        return (new BackendNav())->findMenu('system')['items'];
    }
}
