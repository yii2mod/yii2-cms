CMS Extension
========================
* [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/?branch=master) 
* [![Build Status](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/build-status/master)


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


CONFIGURATION
======================================
> If you use this extension separate from the [base template](https://github.com/yii2mod/base), then you need execute migration by the following command:
```
php yii migrate --migrationPath=@vendor/yii2mod/yii2-cms/migrations
```

> NOTE: comments extension used in 1.0.5 release and above, if you are using a previous version of this extension, you don't need to install [comments extension](https://github.com/yii2mod/yii2-comments).

1) To use this extension first you need to configure the [comments extension](https://github.com/yii2mod/yii2-comments), after that you have to configure the main config in your application:
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
> **You can then access to management section through the following URL:**

> http://localhost/path/to/index.php?r=admin/cms/index
  

2) Add new Rule class to the `urlManager` array in your application configuration by the following code:
 
```php
 'components' => [
        'urlManager' => [
            'rules' => [
                ['class' => 'yii2mod\cms\components\PageUrlRule'],
            ]
        ],
    ],
```

3) Add to SiteController (or configure via `$route` param in `urlManager`):
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
> And now you can create your own pages via the admin panel, and access them via the `url` of each page.

**Additional features:**

1. You can insert your own widget on the page by the following steps:
    * Create the widget and add the static function for example:
   
     ```php
       public static function insertList() {
           return self::widget([
               //your params
           ]);
       }
      ```
    * When you create the page via admin panel add the following code to the content:
    
      ```
         \app\widgets\MyWidget:list() // call the function insertList placed in MyWidget class
      ```
