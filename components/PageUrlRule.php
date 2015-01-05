<?php

namespace yii2mod\cms\components;

use yii\web\UrlRule;
use yii2mod\cms\models\CmsModel;
use yii2mod\cms\models\enumerables\CmsStatus;

/**
 * @author  Kravchuk Dmitry
 * @author  Dmitry Semenov <disemx@gmail.com>
 * Class PageUrlRule
 * @package yii2mod\cms\components
 */
class PageUrlRule extends UrlRule
{

    /**
     * @var string
     */
    public $pattern = '<\w+>';

    /**
     * @var string
     */
    public $connectionID = 'db';

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
     * @return boolean
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
        return parent::parseRequest($manager, $request);
    }

}
