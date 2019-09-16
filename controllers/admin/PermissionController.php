<?php

namespace panix\mod\rbac\controllers\admin;

use Yii;
use yii\rbac\Item;
use panix\mod\rbac\base\ItemController;
use panix\mod\rbac\models\AuthItemModel;

/**
 * Class PermissionController
 *
 * @package panix\mod\rbac\controllers
 */
class PermissionController extends ItemController
{

    public function actionIndex()
    {
        $searchModel = Yii::createObject($this->searchClass);
        $searchModel->type = $this->type;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->pageName = Yii::t('rbac/default', 'PERMISSIONS');

        $this->buttons = [
            [
                'icon' => 'add',
                'label' => Yii::t('rbac/default', 'CREATE_PERMISSIONS'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('rbac/default', 'MODULE_NAME'),
            'url' => '#',
        ];
        $this->breadcrumbs[] = $this->pageName;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }



    public function actionCreate()
    {
        $model = new AuthItemModel();
        $model->type = Item::TYPE_PERMISSION;



        $this->pageName = Yii::t('rbac/default', 'CREATE_PERMISSIONS');
        $this->breadcrumbs[] = [
            'label' => Yii::t('rbac/default', 'MODULE_NAME'),
            'url' => ['#'],
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('rbac/default', 'PERMISSIONS'),
            'url' => ['index'],
        ];
        $this->breadcrumbs[] = $this->pageName;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('rbac/default', 'Item has been saved.'));

            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('create', ['model' => $model]);
    }
}
