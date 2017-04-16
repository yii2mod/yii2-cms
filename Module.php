<?php

namespace yii2mod\cms;

/**
 * Class Module
 *
 * @package yii2mod\cms
 */
class Module extends \yii\base\Module
{
    /**
     * @var string the namespace that controller classes are in
     */
    public $controllerNamespace = 'yii2mod\cms\controllers';

    /**
     * @var string the default route of this module
     */
    public $defaultRoute = 'manage';

    /**
     * @var array imperavi editor options
     */
    public $imperaviEditorOptions = [
        'plugins' => ['video', 'fullscreen', 'table'],
        'options' => [
            'minHeight' => 200,
        ],
    ];

    /**
     * @var bool whether to enable the markdown editor and markdown converter
     */
    public $enableMarkdown = false;

    /**
     * @var array markdown editor options
     */
    public $markdownEditorOptions = [
        'showIcons' => ['code', 'table'],
    ];
}
