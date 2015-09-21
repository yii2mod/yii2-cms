CMS Extension
========================
* [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/?branch=master) 
* [![Build Status](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/build-status/master)

Update warning
--------------

Warning!
Messages moved from `app` to `modcms`. Beware.


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
If you use this extension separate from the [base template](https://github.com/yii2mod/base), then you need execute cms init migration by the following command: 
```
php yii migrate/up --migrationPath=@yii2mod/cms/migrations
```

To use this extension, you have to configure the main config in your application:
```php
'modules' => [
        'admin' => [
            'controllerMap' => [
                'cms' => 'yii2mod\cms\controllers\CmsController'
                // You can set your template files
                // 'layout' => '@app/modules/backend/views/layouts/main',
                // 'viewPath' => '@app/modules/backend/views/cms/',
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
Add to SiteController (or configure via `$route` param in urlManager):
```php
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'page' => [
                'class' => 'yii2mod\cms\actions\PageAction',
                // You can set your template files
                'view' => '@app/views/site/page'
            ],
        ];
    }
```
