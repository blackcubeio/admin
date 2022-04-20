Blackcube Admin
===============

[![pipeline status](https://code.redcat.io/blackcube/admin/badges/master/pipeline.svg)](https://code.redcat.io/blackcube/admin/commits/master)
[![coverage report](https://code.redcat.io/blackcube/admin/badges/master/coverage.svg)](https://code.redcat.io/blackcube/admin/commits/master)

Pre-requisites
--------------

 * PHP 7.4+
   * Extension `dom`
   * Extension `fileinfo`
   * Extension `intl`
   * Extension `json`
   * Extension `mbstring`
 * Apache or NginX
 * Blackcube core 3;x

Pre-flight
----------

Add blackcube admin to the project

```
composer require "blackcube/admin" 
```
   
Installation
------------

> **Beware**: `Blackcube admin` can only be installed if `Blackcube core` is already set up 


### Inject Blackcube admin in application

```php 
// main configuration file
   'container' => [
      'singletons' => [
         // local filesystem
         blackcube\core\components\Flysystem::class => [
            'class' => blackcube\core\components\FlysystemLocal::class,
            'path' => getstrenv('FILESYSTEM_LOCAL_PATH'),
         ],
         // or s3
         blackcube\core\components\Flysystem::class => [
            'class' => blackcube\core\components\FlysystemAwsS3::class,
            'key' => getstrenv('FILESYSTEM_S3_KEY'),
            'secret' => getstrenv('FILESYSTEM_S3_SECRET'),
            'bucket' => getstrenv('FILESYSTEM_S3_BUCKET'),
            'region' => getstrenv('FILESYSTEM_S3_REGION'),
            'version' => 'latest',
            'endpoint' => getstrenv('FILESYSTEM_S3_ENDPOINT'),
            'pathStyleEndpoint' => getboolenv('FILESYSTEM_S3_PATH_STYLE'),
         ],
      ]
   ],
   // ...
   'bootstrap' => [
      // ... boostrapped modules
      'blackcube', // blackcube core
      'bo', // blackcube admin
   ],
   // ...
   'modules' => [
      // ... other modules
      'blackcube' => [
         'class' => blackcube\core\Module::class,
         'plugins' => [
            // additional plugins
         ],
         'cmsEnabledmodules' => [
            // additional modules
         ],
         'allowedParameterDomains' => ['],
         'cache' => 'cache',
      ],
      'bo' => [
         'class' => blackcube\admin\Module::class,
         'adminTemplatesAlias' => '@app/admin',
         'additionalAssets' => [
            // additional modules
         ],
         'modules' => [
            // additional modules
         ],
         'cache' => 'cache',
      ],
   ],
// ...
```

### Update DB

Add needed tables in DB

```
php yii.php migrate
```

Init all RBAC Roles and permissions

```
php yii.php bc:rbac
```

> the command must be run each time a new Rbac (role / permssion) is added through a module or plugin

### Create initial administrator

```
php yii.php bc:admin/create 
```

> Blackcube admin is now ready, you can access it through `https://host.domain/bo`
