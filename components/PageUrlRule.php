<?php

namespace yii2mod\cms\components;

use yii\web\UrlRule;
use yii2mod\cms\models\CmsModel;
use yii2mod\cms\models\enumerables\CmsStatus;

/**
 * Class PageUrlRule
 * @author  Kravchuk Dmitry
 * @author  Dmitry Semenov <disemx@gmail.com>
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
     * @author Kravchuk Dmitry
     *
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request    $request
     *
     * @return boolean
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        // get path without '/' in end
        $alias = preg_replace("#/$#", "", $pathInfo);
        // find url alias in db
        $page = CmsModel::find()
            ->where(['url' => $alias, 'status' => CmsStatus::ENABLED])
            ->one();
        // redirect to page
        if (!is_null($page)) {
            $params['pageAlias'] = $alias;
            $params['pageId'] = $page->id;
            return [$this->route, $params];
        }
        return parent::parseRequest($manager, $request);
    }

}