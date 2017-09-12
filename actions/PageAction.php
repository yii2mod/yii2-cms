<?php

namespace yii2mod\cms\actions;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii2mod\cms\models\CmsModel;

/**
 * Class PageAction
 *
 * @package yii2mod\cms\actions
 */
class PageAction extends Action
{
    /**
     * @var string custom layout
     */
    public $layout;

    /**
     * @var string Page path
     */
    public $view = '@vendor/yii2mod/yii2-cms/views/page';

    /**
     * @var mixed pageId
     */
    public $pageId;

    /**
     * @var array base template params
     */
    public $baseTemplateParams = [];

    /**
     * @var array
     */
    public $commentWidgetParams = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->pageId)) {
            $this->pageId = Yii::$app->request->get('pageId');
        }

        if (!empty($this->layout)) {
            $this->controller->layout = $this->layout;
        }
    }

    /**
     * Run action
     *
     * @throws \yii\web\NotFoundHttpException
     *
     * @return string
     */
    public function run()
    {
        $model = $this->findModel();
        $model->content = $this->parseBaseTemplateParams($model->content);

        return $this->controller->render($this->view, [
            'model' => $model,
            'commentWidgetParams' => $this->commentWidgetParams,
        ]);
    }

    /**
     * Parse base template params, like {homeUrl}
     *
     * @param $pageContent
     *
     * @return string
     */
    protected function parseBaseTemplateParams(string $pageContent)
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
     *
     * If one of this params exist in page content, it will be parsed
     *
     * @return array
     */
    protected function getBaseTemplateParams()
    {
        return ArrayHelper::merge($this->baseTemplateParams, [
            'homeUrl' => Yii::$app->urlManager->baseUrl,
            'siteName' => Yii::$app->name,
        ]);
    }

    /**
     * Find CmsModel
     *
     * @return CmsModel
     *
     * @throws NotFoundHttpException
     */
    protected function findModel(): CmsModel
    {
        if (($model = CmsModel::findOne($this->pageId)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('yii2mod.cms', 'The requested page does not exist.'));
    }
}
