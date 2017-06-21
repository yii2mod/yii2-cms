<?php

namespace yii2mod\cms;

use froala\froalaeditor\FroalaEditorWidget;
use Yii;

/**
 * Class Widget
 *
 * @package yii2mod\cms
 */
class Widget extends FroalaEditorWidget
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        $request = Yii::$app->getRequest();

        if ($request->enableCsrfValidation) {
            $this->clientOptions['imageUploadParams'][$request->csrfParam] = $request->getCsrfToken();
            $this->clientOptions['imageManagerDeleteParams'][$request->csrfParam] = $request->getCsrfToken();
        }
    }
}
