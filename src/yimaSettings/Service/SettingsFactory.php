<?php
namespace yimaSettings\Service;

use yimaSettings\DataStore\FileStore\FileDataStore;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class SettingsFactory
 *
 * @package yimaSettings\Service
 */
class SettingsFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $setting = new FileDataStore();
        $dir = \yimaSettings\Module::getDir().'/../../data';
        $setting->setStorageFolder($dir);
        $setting->setServiceManager($serviceLocator);

        return $setting;
    }
}
