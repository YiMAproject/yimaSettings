<?php
namespace yimaSettings\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class SettingsFactory
 *
 * @package yimaSettings\Service
 */
class SettingsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config  = $serviceLocator->get('Config');
        $config  = (isset($config['yima-settings'])) ? $config['yima-settings'] : array();

        $setting = new Settings($config);

        return $setting;
    }
}
