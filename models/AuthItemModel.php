<?php

namespace panix\mod\rbac\models;

use panix\engine\CMS;
use Yii;
use panix\engine\base\Model;
use yii\base\Exception;
use yii\helpers\Json;
use yii\rbac\Item;
use yii\rbac\Rule;

/**
 * Class AuthItemModel
 *
 * @property string $name
 * @property int $type
 * @property string $description
 * @property string $ruleName
 * @property string $data
 * @property Item $item
 */
class AuthItemModel extends Model
{
    public $module = 'rbac';
    /**
     * @var string auth item name
     */
    public $name;

    /**
     * @var int auth item type
     */
    public $type;

    /**
     * @var string auth item description
     */
    public $description;

    /**
     * @var string biz rule name
     */
    public $ruleName;

    /**
     * @var null|string additional data
     */
    public $data;

    /**
     * @var \yii\rbac\ManagerInterface
     */
    protected $manager;

    /**
     * @var Item
     */
    private $_item;
    public $items;

    /**
     * AuthItemModel constructor.
     *
     * @param Item|null $item
     * @param array $config
     */
    public function __construct($item = null, $config = [])
    {
        $this->_item = $item;
        $this->manager = Yii::$app->authManager;

        if ($item !== null) {
            $this->name = $item->name;
            $this->type = $item->type;
            $this->description = $item->description;
            $this->ruleName = $item->ruleName;
            $this->data = $item->data === null ? null : Json::encode($item->data);
        }

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name', 'description', 'data', 'ruleName'], 'trim'],
            [['name', 'type', 'items'], 'required'],
            ['ruleName', 'checkRule'],
            ['name', 'validateName', 'when' => function () {
                return $this->getIsNewRecord() || ($this->_item->name != $this->name);
            }],
            ['type', 'integer'],
            [['description', 'data', 'ruleName'], 'default'],
            ['name', 'string', 'max' => 64],
        ];
    }

    /**
     * Validate item name
     */
    public function validateName()
    {
        $value = $this->name;
        if ($this->manager->getRole($value) !== null || $this->manager->getPermission($value) !== null) {
            $message = Yii::t('yii', '{attribute} "{value}" has already been taken.');
            $params = [
                'attribute' => $this->getAttributeLabel('name'),
                'value' => $value,
            ];
            $this->addError('name', Yii::$app->getI18n()->format($message, $params, Yii::$app->language));
        }
    }

    /**
     * Check for rule
     */
    public function checkRule()
    {
        $name = $this->ruleName;

        if (!$this->manager->getRule($name)) {
            try {
                $rule = Yii::createObject($name);
                if ($rule instanceof Rule) {
                    $rule->name = $name;
                    $this->manager->add($rule);
                } else {
                    $this->addError('ruleName', Yii::t('rbac/default', 'Invalid rule "{value}"', ['value' => $name]));
                }
            } catch (\Exception $exc) {
                $this->addError('ruleName', Yii::t('rbac/default', 'Rule "{value}" does not exists', ['value' => $name]));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels2(): array
    {
        return [
            'name' => Yii::t('rbac/default', 'Name'),
            'type' => Yii::t('rbac/default', 'Type'),
            'description' => Yii::t('rbac/default', 'Description'),
            'ruleName' => Yii::t('rbac/default', 'Rule Name'),
            'data' => Yii::t('rbac/default', 'Data'),
        ];
    }

    /**
     * Check if is new record.
     *
     * @return bool
     */
    public function getIsNewRecord(): bool
    {
        return $this->_item === null;
    }

    /**
     * Find role
     *
     * @param string $id
     *
     * @return null|\self
     */
    public static function find(string $id)
    {
        $item = Yii::$app->authManager->getRole($id);

        if ($item !== null) {
            return new self($item);
        }

        return null;
    }

    /**
     * Save role to [[\yii\rbac\authManager]]
     *
     * @return bool
     */
    public function save(): bool
    {

        if ($this->validate()) {

            if ($this->_item === null) {
                if ($this->type == Item::TYPE_ROLE) {
                    $this->_item = $this->manager->createRole($this->name);
                } else {
                    $this->_item = $this->manager->createPermission($this->name);
                }
                $isNew = true;
                $oldName = false;
            } else {
                $isNew = false;
                $oldName = $this->_item->name;
            }

            $this->_item->name = $this->name;
            $this->_item->description = $this->description;
            $this->_item->ruleName = $this->ruleName;
            $this->_item->data = Json::decode($this->data);

            foreach ($this->manager->getPermissions() as $key => $permission) {
                $this->manager->removeChild($this->_item, $permission);
            }


            if ($isNew) {
                $this->manager->add($this->_item);
            } else {
                $this->manager->update($oldName, $this->_item);
            }

            // $this->setPerm();
            $this->addChildren($this->items);
            return true;
        }

        return false;
    }

    public function setPerm()
    {
        // print_r($this->items);die;
        $this->addChildren($this->items);
        // foreach ($this->items as $item){
        //    $this->manager->add($item);
        // $this->manager->addChild($this->_item, $child);
        // }
        // die('pe');
    }

    /**
     * Add child to Item
     *
     * @param array $items
     *
     * @return bool
     */
    public function addChildren(array $items): bool
    {
        if ($this->_item) {


            foreach ($items as $name) {
                $child = $this->manager->getPermission($name);

                if (empty($child) && $this->type == Item::TYPE_ROLE) {
                    $child = $this->manager->getRole($name);
                }
                try {

                    $this->manager->addChild($this->_item, $child);


                } catch (Exception $e) {

                }

            }
        }

        return true;
    }

    /**
     * Remove child from an item
     *
     * @param array $items
     *
     * @return bool
     */
    public function removeChildren(array $items): bool
    {
        if ($this->_item !== null) {
            foreach ($items as $name) {
                $child = $this->manager->getPermission($name);
                if (empty($child) && $this->type == Item::TYPE_ROLE) {
                    $child = $this->manager->getRole($name);
                }
                $this->manager->removeChild($this->_item, $child);
            }
        }

        return true;
    }

    /**
     * Get all available and assigned roles, permission and routes
     *
     * @return array
     */
    public function getItems(): array
    {
        $available = [];
        $assigned = [];

        if ($this->type == Item::TYPE_ROLE) {
            foreach (array_keys($this->manager->getRoles()) as $name) {
                $available[$name] = 'role';
            }
        }
        foreach (array_keys($this->manager->getPermissions()) as $name) {
            $available[$name] = $name[0] == '/' ? 'route' : 'permission';
        }

        foreach ($this->manager->getChildren($this->_item->name) as $item) {
            $assigned[$item->name] = $item->type == 1 ? 'role' : ($item->name[0] == '/' ? 'route' : 'permission');
            unset($available[$item->name]);
        }

        unset($available[$this->name]);

        return [
            'available' => $available,
            'assigned' => $assigned,
        ];
    }


    public function getItemsDropDown(): array
    {
        $available = [];
        $assigned = [];

        if ($this->type == Item::TYPE_ROLE) {
            foreach (array_keys($this->manager->getRoles()) as $name) {
                $available['Роли'][$name] = $name;
            }
        }
        foreach (array_keys($this->manager->getPermissions()) as $name) {
            $type = $name[0] == '/' ? 'route' : 'permission';
            if (strpos($name, '/admin/') === false) {
                $available['frontend'][$name] = $name;
            } else {
                $available['backend'][$name] = $name;
            }
        }
        if ($this->_item) {
            foreach ($this->manager->getChildren($this->_item->name) as $item) {
                $type = $item->type == 1 ? 'role' : ($item->name[0] == '/' ? 'route' : 'permission');
                if (strpos($item->name, '/admin/') === false) {
                    $assigned[$item->name] = $item->name;
                } else {
                    $assigned[$item->name] = $item->name;
                }
                // unset($available[$item->name]);
            }
        }
        //unset($available[$this->name]);

        return [
            'available' => $available,
            'assigned' => $assigned,
        ];
    }

    /**
     * @return null|Item
     */
    public function getItem()
    {
        return $this->_item;
    }

    /**
     * Get type name
     *
     * @param mixed $type
     *
     * @return string|array
     */
    public static function getTypeName($type = null)
    {
        $result = [
            Item::TYPE_PERMISSION => 'Permission',
            Item::TYPE_ROLE => 'Role',
        ];

        if ($type === null) {
            return $result;
        }

        return $result[$type];
    }
}
