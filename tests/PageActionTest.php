<?php

namespace yii2mod\cms\tests;

use Yii;
use yii\web\NotFoundHttpException;
use yii2mod\cms\actions\PageAction;

/**
 * Class PageActionTest
 * @package yii2mod\cms\tests
 */
class PageActionTest extends TestCase
{
    /**
     * Runs the action.
     * @param array $config
     * @return array|\yii\web\Response response.
     */
    protected function runAction(array $config = [])
    {
        $action = new PageAction('page', $this->createController(), $config);
        return $action->run();
    }

    // Tests :

    public function testViewPage()
    {
        $response = $this->runAction(['pageId' => 1]);
        $this->assertEquals('@vendor/yii2mod/yii2-cms/views/page', $response['view']);
        $this->assertEquals('about-us', $response['params']['model']['url']);
    }

    public function testViewNotExistPage()
    {
        try {
            $this->runAction(['pageId' => 'not exist page']);
        } catch (NotFoundHttpException $e) {
            $this->assertEquals('The requested page does not exist.', $e->getMessage());
        }
    }

    public function testViewPageWithParams()
    {
        $response = $this->runAction([
            'pageId' => 2,
            'baseTemplateParams' => [
                'siteName' => Yii::$app->name
            ]
        ]);
        $this->assertEquals('My site name is My Application', $response['params']['model']['content']);
    }
}