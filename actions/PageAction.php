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
     * @var string
     */
    public $layout = '';

    /**
     * Page path
     * @var string
     */
    public $view = '@vendor/yii2mod/yii2-cms/views/page';

    /**
     * @var null
     */
    public $pageId = null;

    /**
     * Base template params
     * @var array
     */
    public $baseTemplateParams = [];

    /**
     * @throws \yii\web\NotFoundHttpException
     * @return string
     */
    public function run()
    {
        if ($this->pageId === null) {
            $this->pageId = Yii::$app->request->get('pageId');
        }

        if (!is_null($this->pageId)) {
            $model = CmsModel::findOne($this->pageId);
            if ($model) {
                $model->content = $this->parseBaseTemplateParams($model->content);
                if (!empty($this->layout)) {
                    $this->controller->layout = $this->layout;
                }
                return $this->controller->render($this->view, [
                    'model' => $model,
                ]);
            }
        }
        throw new NotFoundHttpException(App::t('modcms', 'The requested page does not exist.'));
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
            'homeUrl' => \Yii::$app->urlManager->baseUrl
        ]);
    }

}
