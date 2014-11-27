<?php

namespace yii2mod\cms\controllers;

use Yii;
use yii2mod\cms\models\CmsModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CmsController implements the CRUD actions for CmsModel model.
 * @author Kravchuk Dmitry
 */
class CmsController extends Controller
{

    /**
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
            ],
        ];
    }

    /**
     * Lists all CmsModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CmsModel::find(),
        ]);

        return $this->render('@vendor/yii2mod/yii2-cms/views/cms/index', [
            'dataProvider' => $dataProvider,
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
