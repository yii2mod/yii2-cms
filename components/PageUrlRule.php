<?php

namespace yii2mod\cms\components;

use yii\base\Object;
use yii\web\UrlRuleInterface;
use yii2mod\cms\models\CmsModel;

/**
 * @author  Kravchuk Dmitry
 * @author  Dmitry Semenov <disemx@gmail.com>
 * Class PageUrlRule
 * Allows dynamic page path.
 * @author Dmitry Semenov <disemx@gmail.com>
 * @package yii2mod\cms\components
 */
class PageUrlRule extends Object implements UrlRuleInterface
{
    /**
     * @var string
     */
    public $route = 'site/page';

    /**
     * Parse request
     *
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request $request
     *
     * @return mixed
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        // get path without '/' in end
        $url = preg_replace("#/$#", "", $pathInfo);
        // find page by url in db
        $page = (new CmsModel())->findPage($url);
        // redirect to page
        if (!is_null($page)) {
            $params['pageAlias'] = $url;
            $params['pageId'] = $page->id;
            return [$this->route, $params];
        }
        return false;
    }
    
    /**
     * @param \yii\web\UrlManager $manager
     * @param string              $route
     * @param array               $params
     *
     * @return bool|string
     */
    public function createUrl($manager, $route, $params)
    {
        if ($route != $this->route || !array_key_exists('pageAlias', $params)) {
            return false;
        }
        $url = $params['pageAlias'];
        $page = (new CmsModel())->findPage($url);
        if (!$page) {
            return false;
        } else {
            return "/{$url}/";
        }
    }
}
