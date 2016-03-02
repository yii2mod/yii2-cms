<?php

namespace yii2mod\cms\models;

use Yii;
use yii\db\ActiveRecord;
use yii2mod\cms\models\enumerables\CmsStatus;

/**
 * Cms model
 *
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property integer $commentAvailable
 * @property string $metaTitle
 * @property string $metaDescription
 * @property string $metaKeywords
 * @property integer $createdAt
 * @property integer $updatedAt
 */
class CmsModel extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%Cms}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'title', 'content', 'metaTitle'], 'required'],
            [['url'], 'match', 'pattern' => '/^[a-z0-9\/-]+$/'],
            [['content', 'metaTitle', 'metaDescription', 'metaKeywords'], 'string'],
            [['url'], 'unique'],
            [['status', 'createdAt', 'updatedAt', 'commentAvailable'], 'integer'],
            [['url', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii2mod.cms', 'ID'),
            'url' => Yii::t('yii2mod.cms', 'Url'),
            'title' => Yii::t('yii2mod.cms', 'Title'),
            'content' => Yii::t('yii2mod.cms', 'Content'),
            'status' => Yii::t('yii2mod.cms', 'Status'),
            'metaTitle' => Yii::t('yii2mod.cms', 'Meta Title'),
            'metaDescription' => Yii::t('yii2mod.cms', 'Meta Description'),
            'metaKeywords' => Yii::t('yii2mod.cms', 'Meta Keywords'),
            'commentAvailable' => Yii::t('yii2mod.cms', 'Comments available'),
            'createdAt' => Yii::t('yii2mod.cms', 'Date Created'),
            'updatedAt' => Yii::t('yii2mod.cms', 'Date Updated'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt'
            ]
        ];
    }

    /**
     * Find page by url
     *
     * @param $url
     * @return array|null|ActiveRecord
     */
    public function findPage($url)
    {
        return self::find()
            ->where(['url' => $url, 'status' => CmsStatus::ENABLED])
            ->one();
    }

    /**
     * Returns content and replace widgets short codes
     *
     * @return string
     */
    public function getContent()
    {
        $content = preg_replace_callback('/\[\[([^(\[\[)]+:[^(\[\[)]+)\]\]/is', [$this, 'replace'], $this->content);
        return $content;
    }

    /**
     * Replaces widget short code on appropriate widget
     *
     * @param $data
     * @return string
     */
    private function replace($data)
    {
        $widget = explode(':', $data[1]);
        if (class_exists($class = $widget[0]) && method_exists($class, $method = 'insert' . ucfirst($widget[1]))) {
            return call_user_func([$class, $method]);
        }
        return '';
    }
}

    
