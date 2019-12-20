<?php

namespace panix\mod\rbac\controllers\admin;

use Yii;
use yii\rbac\Item;
use panix\mod\rbac\base\ItemController;
use panix\mod\rbac\models\AuthItemModel;
use panix\mod\rbac\models\search\AuthItemSearch;

/**
 * Class PermissionController
 *
 * @package panix\mod\rbac\controllers
 */
class PermissionController extends ItemController
{

    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $searchModel->type = Item::TYPE_PERMISSION;

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



    public function actionUpdate(string $id)
    {
        $this->type = Item::TYPE_PERMISSION;
        $model = $this->findModel($id);

        $this->pageName = Yii::t('rbac/default', 'UPDATE_PERMISSION', $model->name);
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

            return $this->redirect(['update', 'id' => $model->name]);
        }

        return $this->render('update', ['model' => $model]);
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

    protected function findModel(string $id): AuthItemModel
    {
        $auth = Yii::$app->getAuthManager();
        $item = $auth->getPermission($id);

        if (empty($item)) {
            $this->error404();
        }

        return new AuthItemModel($item);
    }
}
