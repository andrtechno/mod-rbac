<?php

namespace panix\mod\rbac\models\search;

use dosamigos\arrayquery\ArrayQuery;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\rbac\Item;

/**
 * Class AuthItemSearch
 *
 * @package panix\mod\rbac\models\search
 */
class AuthItemSearch extends Model
{
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
     * @var string auth item rule name
     */
    public $ruleName;

    /**
     * @var int the default page size
     */
    public $pageSize = 25;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name', 'ruleName', 'description'], 'trim'],
            [['type'], 'integer'],
            [['name', 'ruleName', 'description'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'name' => Yii::t('rbac/default', 'Name'),
            'type' => Yii::t('rbac/default', 'Type'),
            'description' => Yii::t('rbac/default', 'Description'),
            'rule' => Yii::t('rbac/default', 'Rule'),
            'data' => Yii::t('rbac/default', 'Data'),
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return \yii\data\ArrayDataProvider
     */
    public function search(array $params): ArrayDataProvider
    {
        $authManager = Yii::$app->getAuthManager();

        if ($this->type == Item::TYPE_ROLE) {
            $items = $authManager->getRoles();
        } else {
            $items = array_filter($authManager->getPermissions(), function ($item) {
                return strpos($item->name, '/') !== 0;
            });
        }

        $query = new ArrayQuery($items);

        $this->load($params);

        if ($this->validate()) {
            $query->addCondition('name', $this->name ? "~{$this->name}" : null)
                ->addCondition('ruleName', $this->ruleName ? "~{$this->ruleName}" : null)
                ->addCondition('description', $this->description ? "~{$this->description}" : null);
        }

        return new ArrayDataProvider([
            'allModels' => $query->find(),
            'sort' => [
                'attributes' => ['name'],
            ],
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
        ]);
    }
}
