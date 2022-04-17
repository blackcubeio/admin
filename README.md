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
// ...
    'bootstrap' => [
        // ... boostrapped modules
        'blackcube', // blackcube core
        'bo', // blackcube admin
    ],
    'modules' => [
        // ... other modules
        'blackcube' => [
            'class' => blackcube\core\Module::class,
        ],
        'bo' => [
            'class' => blackcube\admin\Module::class,
            'adminTemplatesAlias' => '@app/admin', // where special admin templates are stored
            ],
        ],
    ],
// ...
```

### Update DB

Add needed tables in DB

```
php yii.php badmin:migrate
```

Init all RBAC Roles and permissions

```
php yii.php badmin:rbac
```
 
### Create initial administrator

```
php yii.php badmin:admin/create 
```

> Blackcube admin is now ready, you can access it through `https://host.domain/bo`
