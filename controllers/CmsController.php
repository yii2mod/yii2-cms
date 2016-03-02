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
 * Class CmsController
 * @package yii2mod\cms\controllers
 */
class CmsController extends Controller
{
    /**
     * @var string view path
     */
    public $viewPath = '@vendor/yii2mod/yii2-cms/views/cms/';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'delete' => ['post']
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
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

        return $this->render($this->viewPath . 'index', [
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
            Yii::$app->session->setFlash('success', Yii::t('yii2mod.cms', 'Page has been created.'));
            return $this->redirect(['index']);
        }

        return $this->render($this->viewPath . 'create', [
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
            Yii::$app->session->setFlash('success', Yii::t('yii2mod.cms', 'Page has been updated.'));
            return $this->redirect(['index']);
        }
        return $this->render($this->viewPath . 'update', [
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
        Yii::$app->session->setFlash('success', Yii::t('yii2mod.cms', 'Page has been deleted.'));
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
            throw new NotFoundHttpException(Yii::t('yii2mod.cms', 'The requested page does not exist.'));
        }
    }

}
