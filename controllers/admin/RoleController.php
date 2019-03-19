<?php

namespace panix\mod\rbac\controllers\admin;

use yii\rbac\Item;
use panix\mod\rbac\base\ItemController;

/**
 * Class RoleController
 *
 * @package panix\mod\rbac\controllers
 */
class RoleController extends ItemController
{
    /**
     * @var int
     */
    protected $type = Item::TYPE_ROLE;

    /**
     * @var array
     */
    protected $labels = [
        'Item' => 'Role',
        'Items' => 'Roles',
    ];
}
