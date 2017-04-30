Yii2 Insert Update Behavior
===============
Simple Behavior INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist kozhemin/yii2-insert-update-behavior "*"
```

or add

```
"kozhemin/yii2-insert-update-behavior": "*"
```

to the require section of your `composer.json` file.


Usage
-----

This behavior allows you to create queries for INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE

For example:

Attach a new behavior to your model

```php
   public function behaviors()
   {
       return[
            \kozhemin\dbHelper\InsertUpdate::className(),
       ];
   }
```

usage

```php
    //INSERT ON DUPLICATE KEY UPDATE
    $model = new Post();
    $model->InsertUpdate($dataInsert)
```
or

```php
    //INSERT IGNORE
    $model = new Post();
    $model->insertIgnore($dataInsert)
```