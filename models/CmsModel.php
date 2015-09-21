<?php

namespace yii2mod\cms\models;

use Yii;
use yii\db\ActiveRecord;
use yii2mod\cms\models\enumerables\CmsStatus;

/**
 * This is the model class for table "Cms".
 * @property integer $id
 * @property string  $url
 * @property string  $title
 * @property string  $content
 * @property string  $default_content
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
     * Declares the name of the database table associated with this AR class.
     * By default this method returns the class name as the table name by calling [[Inflector::camel2id()]]
     * with prefix [[Connection::tablePrefix]]. For example if [[Connection::tablePrefix]] is 'tbl_',
     * 'Customer' becomes 'tbl_customer', and 'OrderItem' becomes 'tbl_order_item'. You may override this method
     * if the table is not named after this convention.
     *
     * @return string the table name
     */
    public static function tableName()
    {
        return '{{%Cms}}';
    }

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     * @return array validation rules
     * @see scenarios()
     */
    public function rules()
    {
        return [
            [['url', 'title', 'content', 'metaTitle'], 'required'],
            [['url'], 'match', 'pattern' => '/^[a-z0-9\/-]+$/'],
            [['content', 'metaTitle', 'metaDescription', 'metaKeywords'], 'string'],
            [['url'], 'unique'],
            [['status', 'createdAt', 'updatedAt'], 'integer'],
            [['url', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * Attribute labels are mainly used for display purpose. For example, given an attribute
     * `firstName`, we can declare a label `First Name` which is more user-friendly and can
     * be displayed to end users.
     *
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('modcms', 'ID'),
            'url' => Yii::t('modcms', 'Url'),
            'title' => Yii::t('modcms', 'Title'),
            'content' => Yii::t('modcms', 'Content'),
            'default_content' => Yii::t('modcms', 'Default Content'),
            'status' => Yii::t('modcms', 'Status'),
            'metaTitle' => Yii::t('modcms', 'Meta Title'),
            'metaDescription' => Yii::t('modcms', 'Meta Description'),
            'metaKeywords' => Yii::t('modcms', 'Meta Keywords'),
            'createdAt' => Yii::t('modcms', 'Date Created'),
            'updatedAt' => Yii::t('modcms', 'Date Updated'),
        ];
    }

   /**
     * Returns a list of behaviors that this component should behave as.
     *
     * Child classes may override this method to specify the behaviors they want to behave as.
     *
     * @return mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createdAt', 'updatedAt'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updatedAt'],
                ],
            ]
        ];
    }

    /**
     * Find page
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
     * Reverts model to default data
     *
     * @return $this
     */
    public function revert()
    {
        $this->content = $this->default_content;
        return $this;
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

    
