Key:Value Settings Module
=========

*this module is part of Yima Application Framework*

With this module you have ability to save some key/value settings and retrieve these settings within application.

Get Settings
------------

#### From Service Manager
```php
$yimaSettings = $serviceManager->get('yimaSettings');
```

#### As Controller Plugin
```php
$yimaSettings = $this->settingHelper();
```

#### As ViewRenderer Plugin
```php
$yimaSettings = $this->settingHelper();
```

Installation
-----------

Composer installation:

require ```rayamedia/yima-settings``` in your ```composer.json```

Or clone to modules folder

Enable module with name ```yimaSettings```
