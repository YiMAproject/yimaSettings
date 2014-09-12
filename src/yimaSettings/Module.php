<?php
namespace yimaSettings;

use yimaSettings\Service\Listeners\AggregateListeners;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
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
    ViewHelperProviderInterface
{
    /**
     * Initialize workflow
     *
     * @param  ModuleManagerInterface $manager
     * @return void
     */
    public function init(ModuleManagerInterface $moduleModuleManager)
    {
        /** @var $sharedEvents \Zend\EventManager\SharedEventManager */
        $sharedEvents = $moduleModuleManager->getEventManager()->getSharedManager();
        // attach events listeners
        // * merge merged general settings with app config
        $sharedEvents->attachAggregate(new AggregateListeners());
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * @inheritdoc
     *
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                # fetch settings entity and related form for a section
                'yimaSettings' => 'yimaSettings\Service\SettingsFactory',
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
                'setting' => 'yimaSettings\View\Helper\SettingHelper',
            ),
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
