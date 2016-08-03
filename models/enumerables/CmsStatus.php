<?php

namespace yii2mod\cms\models\enumerables;

use yii2mod\enum\helpers\BaseEnum;

/**
 * Class CmsStatus
 * @package yii2mod\cms\models\enumerables
 */
class CmsStatus extends BaseEnum
{
    const ENABLED = 1;
    const DISABLED = 0;

    /**
     * @var string message category
     */
    public static $messageCategory = 'yii2mod.cms';

    /**
     * @var array
     */
    public static $list = [
        self::ENABLED => 'Enabled',
        self::DISABLED => 'Disabled'
    ];
}