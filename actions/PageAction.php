<?php

namespace yii2mod\cms\actions;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii2mod\cms\models\CmsModel;

/**
 * Class PageAction
 * Render cms page
 * @package yii2mod\cms\actions
 */
class PageAction extends Action
{

    /**
     * @var string custom layout
     */
    public $layout = '';

    /**
     * @var string Page path
     */
    public $view = '@vendor/yii2mod/yii2-cms/views/page';

    /**
     * @var null pageId
     */
    public $pageId = null;

    /**
     * @var array base template params
     */
    public $baseTemplateParams = [];

    /**
     * Run action
     * @throws \yii\web\NotFoundHttpException
     * @return string
     */
    public function run()
    {
        if ($this->pageId === null) {
            $this->pageId = Yii::$app->request->get('pageId');
        }

        if (!empty($this->pageId)) {
            $model = CmsModel::findOne($this->pageId);
            if (!empty($model)) {
                $model->content = $this->parseBaseTemplateParams($model->content);
                if (!empty($this->layout)) {
                    $this->controller->layout = $this->layout;
                }
                return $this->controller->render($this->view, [
                    'model' => $model,
                ]);
            }
        }
        throw new NotFoundHttpException(Yii::t('yii2mod.cms', 'The requested page does not exist.'));
    }

    /**
     * Parse base template params, like {homeUrl}
     * @param $pageContent
     * @return string
     */
    protected function parseBaseTemplateParams($pageContent)
    {
        $params = $this->getBaseTemplateParams();
        $p = [];
        foreach ($params as $name => $value) {
            $p['{' . $name . '}'] = $value;
        }

        return strtr($pageContent, $p);
    }

    /**
     * Return base template params
     * If one of this params exist in page content, it will be parsed
     */
    protected function getBaseTemplateParams()
    {
        return ArrayHelper::merge($this->baseTemplateParams, [
            'homeUrl' => Yii::$app->urlManager->baseUrl,
            'siteName' => Yii::$app->name
        ]);
    }

}
