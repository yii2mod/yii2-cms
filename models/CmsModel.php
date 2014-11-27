<?php

namespace yii2mod\cms\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * This is the model class for table "Cms".
 * @author  Kravchuk Dmitry
 * @package yii2mod\cms\models
 * @property integer $id
 * @property string  $url
 * @property string  $title
 * @property string  $content
 * @property integer $status
 * @property string  $metaTitle
 * @property string  $metaDescription
 * @property string  $metaKeywords
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
        return 'Cms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'title', 'content', 'metaTitle'], 'required'],
            [['url'], 'filter', 'filter' => [$this, 'filterUrl']],
            [['content', 'metaTitle', 'metaDescription', 'metaKeywords'], 'string'],
            [['url'], 'unique'],
            [['status', 'createdAt', 'updatedAt'], 'integer'],
            [['url', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * Modify url
     * @author Kravchuk Dmitry
     * @return string
     */
    public function filterUrl()
    {
        return Inflector::slug($this->url);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'status' => Yii::t('app', 'Status'),
            'metaTitle' => Yii::t('app', 'Meta Title'),
            'metaDescription' => Yii::t('app', 'Meta Description'),
            'metaKeywords' => Yii::t('app', 'Meta Keywords'),
            'createdAt' => Yii::t('app', 'Date Created'),
            'updatedAt' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * @return mixed
     */
    public function behaviors()
    {
        $behaviors['CTimestampBehavior'] = [
            'class' => 'yii\behaviors\TimestampBehavior',
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['createdAt'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['updatedAt'],
            ]
        ];
        return $behaviors;
    }
}

    