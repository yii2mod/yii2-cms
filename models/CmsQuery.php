<?php

namespace yii2mod\cms\models;

use yii\db\ActiveQuery;
use yii2mod\cms\models\enumerables\CmsStatus;

/**
 * Class CmsQuery
 *
 * @package yii2mod\cms\models
 */
class CmsQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function enabled()
    {
        return $this->andWhere(['status' => CmsStatus::ENABLED]);
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function byUrl(string $url)
    {
        return $this->andWhere(['url' => $url]);
    }
}
