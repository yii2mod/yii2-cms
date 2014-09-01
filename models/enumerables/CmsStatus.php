<?php
namespace yii2mod\cms\models\enumerables;

use yii2mod\enum\helpers\BaseEnum;

/**
 * @author  Kravchuk Dmitry
 * @package yii2mod\cms\models\enumerables
 */
class CmsStatus extends BaseEnum
{
    const ENABLED = 1;
    const DISABLED = 0;

    public static $list = [
        self::ENABLED => 'Enabled',
        self::DISABLED => 'Disabled'
    ];
}