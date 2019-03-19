<?php

namespace panix\mod\rbac;

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

    public $routes = [
        'rbac/route' => 'rbac/route/index',
        'rbac/rule' => 'rbac/rule/index',
        'rbac' => 'rbac/assignment/index',


    ];

    /**
     * @var string the default route of this module. Defaults to 'default'
     */
    public $defaultRoute = 'assignment';

    /**
     * @var string the namespace that controller classes are in
     */
    public $controllerNamespace = 'panix\mod\rbac\controllers';
}