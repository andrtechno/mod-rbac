<?php

namespace panix\mod\rbac\controllers\admin;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use panix\mod\rbac\models\RouteModel;
use panix\engine\controllers\AdminController;

/**
 * Class RouteController
 *
 * @package panix\mod\rbac\controllers
 */
class RouteController extends AdminController
{
    /**
     * @var array route model class
     */
    public $modelClass = [
        'class' => RouteModel::class,
    ];

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                    'create' => ['post'],
                    'assign' => ['post'],
                    'remove' => ['post'],
                    'refresh' => ['post'],
                ],
            ],
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['assign', 'remove', 'refresh'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    /**
     * Lists all Route models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Yii::createObject($this->modelClass);
        $this->pageName = Yii::t('rbac/default', 'ROUTES');
        $this->breadcrumbs[] = [
            'label' => Yii::t('rbac/default', 'MODULE_NAME'),
            'url' => ['/admin/rbac']
        ];
        $this->breadcrumbs[] = $this->pageName;
        return $this->render('index', ['routes' => $model->getAvailableAndAssignedRoutes()]);
    }

    /**
     * Assign routes
     *
     * @return array
     */
    public function actionAssign(): array
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = Yii::createObject($this->modelClass);
        $model->addNew($routes);

        return $model->getAvailableAndAssignedRoutes();
    }

    /**
     * Remove routes
     *
     * @return array
     */
    public function actionRemove(): array
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = Yii::createObject($this->modelClass);
        $model->remove($routes);

        return $model->getAvailableAndAssignedRoutes();
    }

    /**
     * Refresh cache of routes
     *
     * @return array
     */
    public function actionRefresh(): array
    {
        $model = Yii::createObject($this->modelClass);
        $model->invalidate();

        return $model->getAvailableAndAssignedRoutes();
    }
}
