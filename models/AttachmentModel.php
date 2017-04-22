<?php

namespace yii2mod\cms\models;

use Yii;
use yii\db\ActiveRecord;
use yii2tech\ar\file\ImageFileBehavior;

/**
 * This is the model class for table "{{%attachment}}".
 *
 * @property int $id
 * @property string $file_extension
 * @property int $file_version
 */
class AttachmentModel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_version'], 'integer'],
            [['file_extension'], 'string', 'max' => 255],
            ['file', 'file', 'mimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'], 'skipOnEmpty' => !$this->isNewRecord],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii2mod.cms', 'ID'),
            'file_extension' => Yii::t('yii2mod.cms', 'File Extension'),
            'file_version' => Yii::t('yii2mod.cms', 'File Version'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'file' => [
                'class' => ImageFileBehavior::class,
                'fileStorageBucket' => 'attachment',
                'fileExtensionAttribute' => 'file_extension',
                'fileVersionAttribute' => 'file_version',
                'fileTransformations' => [
                    'origin',
                    'thumbnail' => [250, 250],
                ],
            ],
        ];
    }
}
