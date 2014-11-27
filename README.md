CMS Extension
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/build-status/master)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yii2mod/yii2-cms "*"
```

or add

```json
"yii2mod/yii2-cms": "*"
```

to the require section of your composer.json.


Usage
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
