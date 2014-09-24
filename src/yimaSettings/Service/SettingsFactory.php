<?php
namespace yimaSettings\Service;

use yimaSettings\DataStore\DataStoreAbstract;
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
        /*$config  = $serviceLocator->get('Config');
        $config  = (isset($config['yima-settings'])) ? $config['yima-settings'] : array();

        $setting = new Settings($config);*/

        $setting = new DataStoreAbstract();

        return $setting;
    }
}
