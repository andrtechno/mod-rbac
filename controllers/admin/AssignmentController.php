<?php

namespace panix\mod\rbac\controllers\admin;

use panix\engine\controllers\AdminController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use panix\mod\rbac\models\AssignmentModel;
use panix\mod\rbac\models\search\AssignmentSearch;

/**
 * Class AssignmentController
 *
 * @package panix\mod\rbac\controllers
 */
class AssignmentController extends AdminController
{
    /**
     * @var string search class name for assignments search
     */
    public $searchClass = [
        'class' => AssignmentSearch::class,
    ];

    /**
     * @var string id column name
     */
    public $idField = 'id';

    /**
     * @var string username column name
     */
    public $usernameField = 'username';

    /**
     * @var array assignments GridView columns
     */
    public $gridViewColumns = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->gridViewColumns)) {
            $this->gridViewColumns = [
                $this->idField,
                $this->usernameField,
            ];
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
           /* 'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'index' => ['get'],
                    'view' => ['get'],
                    'assign' => ['post'],
                    'remove' => ['post'],
                ],
            ],
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['assign', 'remove'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],*/
        ];
    }

    /**
     * List of all assignments
     *
     * @return string
     */
    public function actionIndex()
    {
        /* @var AssignmentSearch */
        $searchModel = Yii::createObject($this->searchClass);

        if ($searchModel instanceof AssignmentSearch) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identityClass, $this->idField, $this->usernameField);
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        $this->pageName = Yii::t('rbac/default', 'ASSIGNMENTS');
        $this->breadcrumbs[] = [
            'label' => Yii::t('rbac/default', 'MODULE_NAME'),
            'url' => ['/admin/rbac']
        ];
        $this->breadcrumbs[] = $this->pageName;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'gridViewColumns' => $this->gridViewColumns,
        ]);
    }

    /**
     * Displays a single Assignment model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView(int $id)
    {
        $model = $this->findModel($id);


        $this->pageName = Yii::t('rbac/default', 'ASSIGNMENT', $model->user->username);
        $this->breadcrumbs[] = [
            'label' => Yii::t('rbac/default', 'MODULE_NAME'),
            'url' => ['/admin/rbac']
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('rbac/default', 'ASSIGNMENTS'),
            'url' => ['/admin/rbac/assignment']
        ];
        $this->breadcrumbs[] = $this->pageName;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Assign items
     *
     * @param int $id
     *
     * @return array
     */
    public function actionAssign(int $id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $assignmentModel = $this->findModel($id);
        $assignmentModel->assign($items);

        return $assignmentModel->getItems();
    }

    /**
     * Remove items
     *
     * @param int $id
     *
     * @return array
     */
    public function actionRemove(int $id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $assignmentModel = $this->findModel($id);
        $assignmentModel->revoke($items);

        return $assignmentModel->getItems();
    }

    /**
     * Finds the Assignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return AssignmentModel the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        $class = Yii::$app->user->identityClass;

        if (($user = $class::findIdentity($id)) !== null) {
            return new AssignmentModel($user);
        }

        $this->error404();
    }
}
