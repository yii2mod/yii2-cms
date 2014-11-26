CMS Extension
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yii2mod/cms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yii2mod/cms/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/yii2mod/cms/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yii2mod/cms/build-status/master)
Installation
======================================
```php
'modules' => [
        'admin' => [
            'controllerMap' => [
                'cms' => 'yii2mod\cms\controllers\CmsController'
            ],
        ],
    ],
```

```php
 'components' => [
        'urlManager' => [
            'rules' => [
                ['class' => 'yii2mod\cms\components\PageUrlRule'],
            ]
        ],
    ],
```
SiteController (or configure via `$route` param in urlManager)
```php
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'page' => [
                'class' => 'yii2mod\cms\actions\PageAction',
            ],
        ];
    }
```
