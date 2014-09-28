Key:Value Settings Module
=========

*this module is part of Yima Application Framework*

Need to give clients access to website configuration settings?
Module To Managing site-wide settings via a single web page

![yimaSettings example screenshot](https://raw.githubusercontent.com/YiMAproject/yimaSettings/master/screenshot.jpg)

Settings are exposed to the administration panel via a simple configuration format.

Module authors can also easily include their own specific configuration settings right from their module.config.php file.

Get Settings Service
------------

##### From Service Manager
```php
$yimaSettings = $serviceManager->get('yimaSettings');
```

##### As Controller Plugin
```php
$yimaSettings = $this->settingHelper();
```

##### As ViewRenderer Plugin
```php
$yimaSettings = $this->settingHelper();
```

Documentation TODO 
-----------

- settings configuration
- how to access settings saved data
- save data to settings


Installation 
-----------

Composer installation:

require ```rayamedia/yima-settings``` in your ```composer.json```

Or clone to modules folder

Enable module with name ```yimaSettings```
