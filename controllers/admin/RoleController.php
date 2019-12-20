<?php

namespace panix\mod\rbac\controllers\admin;

use Mpdf\Tag\P;
use Yii;
use yii\rbac\Item;
use panix\engine\controllers\AdminController;
use panix\mod\rbac\models\AuthItemModel;
use panix\mod\rbac\models\search\AuthItemSearch;

/**
 * Class RoleController
 *
 * @package panix\mod\rbac\controllers
 */
class RoleController extends AdminController
{

    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $searchModel->type = Item::TYPE_ROLE;
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
        //$this->type = Item::TYPE_ROLE;


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

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('rbac/default', 'Item has been saved.'));
            }


            return $this->redirect(['update', 'id' => $model->name]);
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


        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('rbac/default', 'Item has been saved.'));
            }


            return $this->redirect(['update', 'id' => $model->name]);
        }

        return $this->render('create', ['model' => $model]);
    }

    protected function findModel(string $id): AuthItemModel
    {
        $auth = Yii::$app->getAuthManager();
        $item = $auth->getRole($id);

        if (empty($item)) {
            $this->error404();
        }

        return new AuthItemModel($item);
    }
}
