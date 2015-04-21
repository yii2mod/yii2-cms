<?php

namespace yii2mod\cms\controllers;

use Yii;
use yii2mod\cms\models\CmsModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii2mod\cms\models\search\CmsModelSearch;
use yii2mod\editable\EditableAction;
use yii2mod\toggle\actions\ToggleAction;

/**
 * CmsController implements the CRUD actions for CmsModel model.
 */
class CmsController extends Controller
{

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * Child classes may override this method to specify the behaviors they want to behave as.
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ];
    }


    /**
     * Declares external actions for the controller.
     * This method is meant to be overwritten to declare external actions for the controller.
     * @return array
     */
    public function actions()
    {
        return [
            'edit-page' => [
                'class' => EditableAction::className(),
                'modelClass' => CmsModel::className(),
                'forceCreate' => false
            ],
            'toggle' => [
                'class' => ToggleAction::className(),
                'modelClass' => CmsModel::className(),
            ]
        ];
    }

    /**
     * Lists all CmsModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@vendor/yii2mod/yii2-cms/views/cms/index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Creates a new CmsModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Page has been created.');
            return $this->redirect(['index']);
        }

        return $this->render('@vendor/yii2mod/yii2-cms/views/cms/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CmsModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->session->remove('revert')) {
            $model->revert();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Page has been updated.');
            return $this->redirect(['index']);
        }
        return $this->render('@vendor/yii2mod/yii2-cms/views/cms/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CmsModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Page has been deleted.');
        return $this->redirect(['index']);
    }

    /**
     * Reverts an existing CmsModel model to default data
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionRevert($id)
    {
        Yii::$app->session->set('revert', true);
        return $this->redirect(['update', 'id' => $id]);
    }

    /**
     * Finds the CmsModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return CmsModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
