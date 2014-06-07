<?php
namespace yimaSettings;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;

/**
 * Class Module
 *
 * @package yimaSettings
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface,
    ControllerProviderInterface
{
    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        // usually return like this
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * @inheritdoc
     *
     */
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                # fetch settings entity and related form for a section
                'yimaSettings' => 'yimaSettings\Service\Settings',

                # Settings Model (to load and store data)
                'yimaSettings.Model.Settings' => 'yimaSettings\Model\Settings',
            ),
        );
    }

    /**
     * Controller helper services
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getControllerPluginConfig()
    {
        return array(
            'invokables' => array (
                'settingHelper' => 'yimaSettings\Controller\Plugin\SettingHelper',
            ),
        );
    }

    /**
     * @inheritdoc
     *
     */
    public function getControllerConfig()
    {
        /* Merged Config Key "controller" */
        return array(
            'invokables' => array(
                'yimaSettings.Controller.Index' => 'yimaSettings\Controller\IndexController'
            )
        );
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }
}
