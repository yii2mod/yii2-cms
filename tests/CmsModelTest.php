<?php

namespace yii2mod\cms\tests;

use yii2mod\cms\models\CmsModel;

/**
 * Class CmsModelTest
 * @package yii2mod\cms\tests
 */
class CmsModelTest extends TestCase
{
    public function testFindPageByCorrectUrl()
    {
        $page = (new CmsModel())->findPage('about-us');
        $this->assertNotNull($page);
    }

    public function testFindPageByNotCorrectUrl()
    {
        $page = (new CmsModel())->findPage('not-correct-url');
        $this->assertNull($page);
    }
}