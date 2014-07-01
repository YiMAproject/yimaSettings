<?php
namespace yimaSettings;

use yimaSettings\Service\SettingListeners;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;

/**
 * Class Module
 *
 * @package yimaSettings
 */
class Module implements
    InitProviderInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface,
    ViewHelperProviderInterface,
    ControllerProviderInterface
{
    /**
     * Initialize workflow
     *
     * @param  ModuleManagerInterface $manager
     * @return void
     */
    public function init(ModuleManagerInterface $moduleManager)
    {
        /** @var $sharedEvents \Zend\EventManager\SharedEventManager */
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        // attach events listeners
        $sharedEvents->attachAggregate(new SettingListeners());
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
     * @inheritdoc
     *
     */
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                # fetch settings entity and related form for a section
                'yimaSettings' => 'yimaSettings\Service\Settings',

                    # Settings Model (to load and store data)       ↑
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
     * View helper services
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array (
                'settings' => 'yimaSettings\View\Helper\SettingHelper',
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
