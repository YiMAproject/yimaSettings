<?php
namespace yimaSettings;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\Feature\LocatorRegisteredInterface;
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
    ViewHelperProviderInterface,
    LocatorRegisteredInterface
{
    /**
     * Initialize workflow
     * - Attach Listeners
     *   . to merge merged general settings with app config
     *
     * @param \Zend\ModuleManager\ModuleManagerInterface $moduleModuleManager
     * @internal param \Zend\ModuleManager\ModuleManagerInterface $manager
     * @return void
     */
    public function init(ModuleManagerInterface $moduleModuleManager)
    {
        $moduleModuleManager->loadModule('yimaAdminor');
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

    /**
     * Get Module Directory
     *
     * @return string
     */
    public static function getDir()
    {
        return __DIR__;
    }
}
