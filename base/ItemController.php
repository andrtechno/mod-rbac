<?php

namespace panix\mod\rbac\base;


use Yii;
use yii\filters\VerbFilter;
use yii\rbac\Item;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use panix\mod\rbac\models\AuthItemModel;
use panix\engine\controllers\AdminController;

/**
 * Class ItemController
 *
 * @package panix\mod\rbac\base
 */
class ItemController extends AdminController
{

    /**
     * @var int Type of Auth Item
     */
    protected $type;

    /**
     * @var array labels use in view
     */
    protected $labels;

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'view' => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'delete' => ['post'],
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
            ],
        ];
    }

    /**
     * Displays a single AuthItem model.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionView(string $id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * Deletes an existing AuthItem model.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionDelete(string $id)
    {
        $model = $this->findModel($id);
        Yii::$app->getAuthManager()->remove($model->item);
        Yii::$app->session->setFlash('success', Yii::t('rbac/default', 'Item has been removed.'));

        return $this->redirect(['index']);
    }

    /**
     * Assign items
     *
     * @param string $id
     *
     * @return array
     */
    public function actionAssign(string $id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $model->addChildren($items);

        return array_merge($model->getItems());
    }

    /**
     * Remove items
     *
     * @param string $id
     *
     * @return array
     */
    public function actionRemove(string $id): array
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $model->removeChildren($items);

        return array_merge($model->getItems());
    }

    /**
     * @inheritdoc

    public function getViewPath(): string
    {
        return $this->module->getViewPath() . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'item';
    }*/

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return AuthItemModel the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(string $id): AuthItemModel
    {
        $auth = Yii::$app->getAuthManager();
        $item = $this->type === Item::TYPE_ROLE ? $auth->getRole($id) : $auth->getPermission($id);

        if (empty($item)) {
            $this->error404();
        }

        return new AuthItemModel($item);
    }
}
