<?php

namespace yii2mod\cms\actions;

use yii\base\Action;
use Yii;
use yii\web\NotFoundHttpException;
use yii2mod\cms\models\CmsModel;

/**
 * Class PageAction
 * Render cms page
 * @author  Kravchuk Dmitry
 * @package yii2mod\cms\actions
 */
class PageAction extends Action
{

    /**
     * @var string
     */
    public $layout = '';

    /**
     * Page path
     * @var string
     */
    protected $view = '@vendor/yii2mod/yii2-cms/views/page';

    /**
     * @author Kravchuk Dmitry
     * @throws \yii\web\NotFoundHttpException
     * @return string
     */
    public function run()
    {
        $pageId = Yii::$app->request->get('pageId');
        if (!is_null($pageId)) {
            $model = CmsModel::findOne($pageId);
            if ($model) {
                return $this->controller->render($this->view, [
                    'model' => $model,
                ]);
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}