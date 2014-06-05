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
     * Implemented Service Listener Features --------------------------------------------------\
     *
     * @see \Zend\ServiceManager\Config
     */

    /**
     * @inheritdoc
     *
     */
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                # Settings Model
                'yimaSettings.Model.Settings' => 'yimaSettings\Model\Settings',

                # fetch settings entity and related form for a section
                'yimaSettings' => 'yimaSettings\Service\Settings',
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
}
