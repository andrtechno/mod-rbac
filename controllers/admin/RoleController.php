<?php

namespace panix\mod\rbac\controllers\admin;

use Yii;
use yii\rbac\Item;
use panix\mod\rbac\base\ItemController;
use panix\mod\rbac\models\AuthItemModel;

/**
 * Class RoleController
 *
 * @package panix\mod\rbac\controllers
 */
class RoleController extends ItemController
{

    public function actionIndex()
    {
        $searchModel = Yii::createObject($this->searchClass);
        $searchModel->type = $this->type;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->pageName = Yii::t('rbac/default', 'ROLES');

        $this->buttons = [
            [
                'icon' => 'add',
                'label' => Yii::t('rbac/default', 'CREATE_ROLE'),
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
        $model = $this->findModel($id);
        $this->pageName = Yii::t('rbac/default', 'UPDATE_ROLE', $model->name);
        $this->breadcrumbs[] = [
            'label' => Yii::t('rbac/default', 'MODULE_NAME'),
            'url' => ['#'],
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('rbac/default', 'ROLES'),
            'url' => ['index'],
        ];
        $this->breadcrumbs[] = $this->pageName;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('rbac/default', 'Item has been saved.'));

            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionCreate()
    {
        $model = new AuthItemModel();
        $model->type = Item::TYPE_ROLE;



        $this->pageName = Yii::t('rbac/default', 'CREATE_ROLE');
        $this->breadcrumbs[] = [
            'label' => Yii::t('rbac/default', 'MODULE_NAME'),
            'url' => ['#'],
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('rbac/default', 'ROLES'),
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
