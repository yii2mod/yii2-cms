<?php

namespace yii2mod\cms\tests;

use Yii;
use yii\helpers\ArrayHelper;
use yii2mod\cms\tests\data\Controller;

/**
 * This is the base class for all yii framework unit tests.
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->mockApplication();

        $this->setupTestDbData();
    }

    protected function tearDown()
    {
        $this->destroyApplication();
    }

    /**
     * Populates Yii::$app with a new application
     * The application will be destroyed on tearDown() automatically.
     *
     * @param array $config The application configuration, if needed
     * @param string $appClass name of the application class to create
     */
    protected function mockApplication($config = [], $appClass = '\yii\web\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'sqlite::memory:',
                ],
                'urlManager' => [
                    'rules' => [
                        ['class' => 'yii2mod\cms\components\PageUrlRule'],
                    ],
                ],
                'request' => [
                    'hostInfo' => 'http://domain.com',
                    'scriptUrl' => '/index.php',
                ],
                'i18n' => [
                    'translations' => [
                        '*' => [
                            'class' => 'yii\i18n\PhpMessageSource',
                            'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                            'sourceLanguage' => 'en',
                        ],
                    ],
                ],
            ],
        ], $config));
    }

    /**
     * @return string vendor path
     */
    protected function getVendorPath()
    {
        return dirname(__DIR__) . '/vendor';
    }

    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        Yii::$app = null;
    }

    /**
     * @param array $config controller config
     *
     * @return Controller controller instance
     */
    protected function createController($config = [])
    {
        return new Controller('test', Yii::$app, $config);
    }

    /**
     * Setup tables for test ActiveRecord
     */
    protected function setupTestDbData()
    {
        $db = Yii::$app->getDb();

        // Structure :

        $db->createCommand()->createTable('cms', [
            'id' => 'pk',
            'url' => 'string not null',
            'title' => 'string not null',
            'content' => 'text not null',
            'status' => 'smallint not null default 1',
            'commentAvailable' => 'smallint not null default 0',
            'metaTitle' => 'text not null',
            'metaDescription' => 'text',
            'metaKeywords' => 'text',
            'createdAt' => 'integer not null',
            'updatedAt' => 'integer not null',
        ])->execute();

        // Data :

        $db->createCommand()->insert('cms', [
            'url' => 'about-us',
            'title' => 'about',
            'content' => 'test content',
            'metaTitle' => 'test content',
            'metaDescription' => 'test content',
            'metaKeywords' => 'test content',
            'createdAt' => time(),
            'updatedAt' => time(),
        ])->execute();

        $db->createCommand()->insert('cms', [
            'url' => 'some-url',
            'title' => 'some title',
            'content' => 'My site name is {siteName}',
            'metaTitle' => 'test content',
            'metaDescription' => 'test content',
            'metaKeywords' => 'test content',
            'createdAt' => time(),
            'updatedAt' => time(),
        ])->execute();
    }
}
