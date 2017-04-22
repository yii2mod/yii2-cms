<?php

namespace yii2mod\cms\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;
use yii\web\UploadedFile;
use yii2mod\cms\models\AttachmentModel;
use yii2mod\cms\models\CmsModel;
use yii2mod\editable\EditableAction;

/**
 * Class ManageController
 *
 * @package yii2mod\cms\controllers
 */
class ManageController extends Controller
{
    /**
     * @var string path to index view file, which is used in admin panel
     */
    public $indexView = '@vendor/yii2mod/yii2-cms/views/cms/index';

    /**
     * @var string path to create view file, which is used in admin panel
     */
    public $createView = '@vendor/yii2mod/yii2-cms/views/cms/create';

    /**
     * @var string path to update view file, which is used in admin panel
     */
    public $updateView = '@vendor/yii2mod/yii2-cms/views/cms/update';

    /**
     * @var string search class name for searching
     */
    public $searchClass = 'yii2mod\cms\models\search\CmsSearch';

    /**
     * @var string model class name for CRUD operations
     */
    public $modelClass = 'yii2mod\cms\models\CmsModel';

    /**
     * @var string class name for attachment model
     */
    public $attachmentModelClass = 'yii2mod\cms\models\AttachmentModel';

    /**
     * @var array verb filter config
     */
    public $verbFilterConfig = [
        'class' => 'yii\filters\VerbFilter',
        'actions' => [
            'index' => ['get'],
            'create' => ['get', 'post'],
            'update' => ['get', 'post'],
            'delete' => ['post'],
            'image-upload' => ['post'],
            'images' => ['get'],
        ],
    ];

    /**
     * @var array access control config
     */
    public $accessControlConfig = [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'roles' => ['admin'],
            ],
        ],
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => $this->verbFilterConfig,
            'access' => $this->accessControlConfig,
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'edit-page' => [
                'class' => EditableAction::class,
                'modelClass' => CmsModel::class,
            ],
        ];
    }

    /**
     * List of all cms models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = Yii::createObject($this->searchClass);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render($this->indexView, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new CmsModel.
     *
     * If creation is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Yii::createObject($this->modelClass);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('yii2mod.cms', 'Page has been created.'));

            return $this->redirect(['index']);
        }

        return $this->render($this->createView, [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CmsModel.
     *
     * If update is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
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

        return $this->render($this->updateView, [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CmsModel.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
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
     * Upload an image
     *
     * @return \yii\web\Response
     *
     * @throws UnprocessableEntityHttpException
     */
    public function actionImageUpload()
    {
        $model = Yii::createObject($this->attachmentModelClass);
        $model->file = UploadedFile::getInstanceByName('file');

        if (!$model->save()) {
            throw new UnprocessableEntityHttpException($model->getFirstError('file'));
        }

        return $this->asJson([
            'link' => $model->getFileUrl('origin'),
        ]);
    }

    /**
     * Return list of all images
     *
     * @return \yii\web\Response
     */
    public function actionImages()
    {
        $result = [];

        foreach (AttachmentModel::find()->each() as $attachment) {
            $result[] = [
                'url' => $attachment->getFileUrl('origin'),
                'thumb' => $attachment->getFileUrl('thumbnail'),
            ];
        }

        return $this->asJson($result);
    }

    /**
     * Finds the CmsModel based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return CmsModel the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $cmsModel = $this->modelClass;

        if (($model = $cmsModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii2mod.cms', 'The requested page does not exist.'));
        }
    }
}
