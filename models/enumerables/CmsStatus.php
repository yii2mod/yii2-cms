<?php

namespace yii2mod\cms\models\enumerables;

use yii2mod\enum\helpers\BaseEnum;

/**
 * Class CmsStatus
 * @package yii2mod\cms\models\enumerables
 */
class CmsStatus extends BaseEnum
{
    public static $messageCategory = 'yii2mod.cms';
    const ENABLED = 1;
    const DISABLED = 0;

    /**
     * @var array
     */
    public static $list = [
        self::ENABLED => 'Enabled',
        self::DISABLED => 'Disabled'
    ];
}