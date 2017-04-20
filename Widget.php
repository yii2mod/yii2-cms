<?php

namespace yii2mod\cms;

use Yii;
use yii\web\JsExpression;

/**
 * Class Widget
 *
 * @package yii2mod\cms
 */
class Widget extends \yii\imperavi\Widget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $request = Yii::$app->getRequest();

        if ($request->enableCsrfValidation && isset($this->options['imageUpload'])) {
            $this->options['uploadImageFields'][$request->csrfParam] = $request->getCsrfToken();
            $this->options['uploadFileFields'][$request->csrfParam] = $request->getCsrfToken();
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();

        $this->registerDefaultCallbacks();
    }

    /**
     * Register default callbacks.
     */
    protected function registerDefaultCallbacks()
    {
        if (isset($this->options['imageUpload']) && !isset($this->options['imageUploadErrorCallback'])) {
            $this->options['imageUploadErrorCallback'] = new JsExpression('function (response) { alert(response.error); }');
        }

        if (isset($this->options['fileUpload']) && !isset($this->options['fileUploadErrorCallback'])) {
            $this->options['fileUploadErrorCallback'] = new JsExpression('function (response) { alert(response.error); }');
        }
    }
}
