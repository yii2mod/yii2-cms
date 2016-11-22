<?php

namespace yii2mod\cms\tests\data;

/**
 * Class Controller
 *
 * @package yii2mod\cms\tests\data
 */
class Controller extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function render($view, $params = [])
    {
        return [
            'view' => $view,
            'params' => $params,
        ];
    }
}
