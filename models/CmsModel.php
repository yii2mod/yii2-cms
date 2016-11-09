<?php

namespace yii2mod\cms\models;

use Yii;
use yii\db\ActiveRecord;
use yii2mod\cms\models\enumerables\CmsStatus;
use yii2mod\enum\helpers\BooleanEnum;

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
        return '{{%cms}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'url', 'metaTitle', 'metaDescription', 'metaKeywords'], 'trim'],
            [['title', 'content', 'url', 'metaTitle'], 'required'],
            ['url', 'match', 'pattern' => '/^[a-z0-9\/-]+$/'],
            ['url', 'unique'],
            [['content', 'metaTitle', 'metaDescription', 'metaKeywords'], 'string'],
            ['status', 'default', 'value' => CmsStatus::ENABLED],
            ['status', 'in', 'range' => [CmsStatus::ENABLED, CmsStatus::DISABLED]],
            ['commentAvailable', 'default', 'value' => BooleanEnum::NO],
            [['status', 'createdAt', 'updatedAt', 'commentAvailable'], 'integer'],
            [['title', 'url'], 'string', 'max' => 255]
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
     * Creates an [[ActiveQueryInterface]] instance for query purpose.
     *
     * @return CmsQuery
     */
    public static function find()
    {
        return new CmsQuery(get_called_class());
    }

    /**
     * Find page by url
     *
     * @param $url
     * @return array|null|ActiveRecord
     */
    public function findPage($url)
    {
        return self::find()->byUrl($url)->enabled()->one();
    }

    /**
     * Returns content and replace widgets short codes
     *
     * Widget short code example: [[\app\widgets\SomeWidget:method]]
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
        if (class_exists($class = $widget[0]) && method_exists($class, $method = $widget[1])) {
            return call_user_func([$class, $method]);
        }

        return '';
    }
}