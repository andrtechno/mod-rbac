<?php

namespace panix\mod\rbac\controllers\admin;

use yii\rbac\Item;
use panix\mod\rbac\base\ItemController;

/**
 * Class PermissionController
 *
 * @package panix\mod\rbac\controllers
 */
class PermissionController extends ItemController
{
    /**
     * @var int
     */
    protected $type = Item::TYPE_PERMISSION;

    /**
     * @var array
     */
    protected $labels = [
        'Item' => 'Permission',
        'Items' => 'Permissions',
    ];
}
