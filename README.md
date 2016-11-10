CMS Extension
========================
Base content management system for Yii Framework 2.0

[![Latest Stable Version](https://poser.pugx.org/yii2mod/yii2-cms/v/stable)](https://packagist.org/packages/yii2mod/yii2-cms) [![Total Downloads](https://poser.pugx.org/yii2mod/yii2-cms/downloads)](https://packagist.org/packages/yii2mod/yii2-cms) [![License](https://poser.pugx.org/yii2mod/yii2-cms/license)](https://packagist.org/packages/yii2mod/yii2-cms)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yii2mod/yii2-cms/?branch=master) [![Build Status](https://travis-ci.org/yii2mod/yii2-cms.svg?branch=master)](https://travis-ci.org/yii2mod/yii2-cms)


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
------------
> If you use this extension separate from the [base template](https://github.com/yii2mod/base), then you need execute migration by the following command:
```bash
$ php yii migrate --migrationPath=@vendor/yii2mod/yii2-cms/migrations
```

1) To use this extension first you need to configure the [comments extension](https://github.com/yii2mod/yii2-comments), after that you have to configure the main config in your application:
```php
'modules' => [
        'admin' => [
            'controllerMap' => [
                'cms' => 'yii2mod\cms\controllers\CmsController',
                // Also you can override some controller properties in following way:
                'cms' => [
                    'class' => 'yii2mod\cms\controllers\CmsController',
                    'searchClass' => [
                        'class' => 'yii2mod\cms\models\search\CmsSearch',
                        'pageSize' => 25
                    ],
                    'modelClass' => 'Your own cms model class',
                    'indexView' => 'custom path to index view file',
                    'createView' => 'custom path to create view file',
                    'updateView' => 'custom path to update view file',
                ],
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
                // Also you can override some action properties in following way:
                'layout' => 'your custom layout',
                'viewPath' => 'your custom view file',
                // You can set parameters that you want to parse before the page is loaded, for example:
                'baseTemplateParams' => [
                   'homeUrl' => Yii::$app->homeUrl,
                   'siteName' => Yii::$app->name
                ]
            ]
        ];
    }
```
> And now you can create your own pages via admin panel.

## Internationalization

All text and messages introduced in this extension are translatable under category 'yii2mod.cms'.
You may use translations provided within this extension, using following application configuration:

```php
return [
    'components' => [
        'i18n' => [
            'translations' => [
                'yii2mod.cms' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/cms/messages',
                ],
                // ...
            ],
        ],
        // ...
    ],
    // ...
];
```

##Additional features:

1. You can insert your own widget on the page by the following steps:
    * Create the widget, for example:
   
     ```php
     <?php
     
      namespace app\widgets;
       
       use yii\base\Widget;
       
       /**
        * Class MyWidget
        * @package app\widgets
        */
       class MyWidget extends Widget
       {
           /**
            * @inheritdoc
            */
           public function run()
           {
               parent::run();
       
               echo 'Text from widget';
           }
       
           /**
            * This function used for render the widget in the cms pages
            *
            * @return string
            */
           public static function show()
           {
               return self::widget([
                   // additional params
               ]);
           }
       }
      ```
    * When you create the page via admin panel add the following code to the page content:
    
      ```
         [[\app\widgets\MyWidget:show]]
      ```
2. You can use parameters in your page content, for example: {siteName}, {homeUrl}. For parsing this parameters you can use the `baseTemplateParams` property:

```php
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'page' => [
                'class' => 'yii2mod\cms\actions\PageAction',
                // You can set parameters that you want to parse before the page is loaded, for example:
                'baseTemplateParams' => [
                   'homeUrl' => 'your site home url',
                   'siteName' => Yii::$app->name
                ]
            ],
        ];
    }
```
