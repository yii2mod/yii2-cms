<?php

namespace yii2mod\cms\models;

use cebe\markdown\GithubMarkdown;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii2mod\cms\models\enumerables\CmsStatus;
use yii2mod\enum\helpers\BooleanEnum;

/**
 * Cms model
 *
 * @property int $id
 * @property string $url
 * @property string $title
 * @property string $content
 * @property string $markdown_content
 * @property int $status
 * @property int $comment_available
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property int $created_at
 * @property int $updated_at
 */
class CmsModel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%cms}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['title', 'content', 'markdown_content', 'url', 'meta_title', 'meta_description', 'meta_keywords'], 'trim'],
            [['title', 'content', 'url', 'meta_title'], 'required'],
            ['markdown_content', 'required', 'when' => function () {
                return Yii::$app->getModule('cms')->enableMarkdown;
            }],
            ['url', 'match', 'pattern' => '/^[a-z0-9\/-]+$/'],
            ['url', 'unique'],
            [['content', 'markdown_content', 'meta_title', 'meta_description', 'meta_keywords'], 'string'],
            ['status', 'default', 'value' => CmsStatus::ENABLED],
            ['status', 'in', 'range' => CmsStatus::getConstantsByName()],
            ['comment_available', 'boolean'],
            ['comment_available', 'default', 'value' => BooleanEnum::NO],
            [['title', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('yii2mod.cms', 'ID'),
            'url' => Yii::t('yii2mod.cms', 'Url'),
            'title' => Yii::t('yii2mod.cms', 'Title'),
            'content' => Yii::t('yii2mod.cms', 'Content'),
            'markdown_content' => Yii::t('yii2mod.cms', 'Markdown Content'),
            'status' => Yii::t('yii2mod.cms', 'Status'),
            'meta_title' => Yii::t('yii2mod.cms', 'Meta Title'),
            'meta_description' => Yii::t('yii2mod.cms', 'Meta Description'),
            'meta_keywords' => Yii::t('yii2mod.cms', 'Meta Keywords'),
            'comment_available' => Yii::t('yii2mod.cms', 'Comments available'),
            'created_at' => Yii::t('yii2mod.cms', 'Date Created'),
            'updated_at' => Yii::t('yii2mod.cms', 'Date Updated'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @return CmsQuery
     */
    public static function find(): CmsQuery
    {
        return new CmsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate(): bool
    {
        if (parent::beforeDelete()) {
            if (Yii::$app->getModule('cms')->enableMarkdown) {
                $this->content = (new GithubMarkdown())->parse($this->markdown_content);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Find page by url
     *
     * @param $url
     *
     * @return null|ActiveRecord
     */
    public function findPage(string $url): ?ActiveRecord
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
    public function getContent(): string
    {
        $content = preg_replace_callback('/\[\[([^(\[\[)]+:[^(\[\[)]+)\]\]/is', [$this, 'replace'], $this->content);

        return $content;
    }

    /**
     * Replaces widget short code on appropriate widget
     *
     * @param $data
     *
     * @return string
     */
    private function replace(array $data): string
    {
        $widget = explode(':', $data[1]);
        if (class_exists($class = $widget[0]) && method_exists($class, $method = $widget[1])) {
            return call_user_func([$class, $method]);
        }

        return '';
    }
}
