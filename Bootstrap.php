<?php

namespace yii2mod\cms;

use yii\base\BootstrapInterface;

/**
 * Class Bootstrap
 *
 * @package yii2mod\cms
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if (!isset($app->get('i18n')->translations['yii2mod.cms'])) {
            $app->get('i18n')->translations['yii2mod.cms'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@yii2mod/cms/messages',
            ];
        }

        if (!$app->hasModule('comment')) {
            $app->setModule('comment', ['class' => 'yii2mod\comments\Module']);
        }

        if (!$app->has('fileStorage')) {
            $app->set('fileStorage', [
                'class' => 'yii2tech\filestorage\local\Storage',
                'basePath' => '@webroot/files',
                'baseUrl' => '@web/files',
                'filePermission' => 0777,
                'buckets' => [
                    'item' => [
                        'baseSubPath' => 'attachment',
                    ],
                ],
            ]);
        }
    }
}
