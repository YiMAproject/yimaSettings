<?php
namespace yimaSettings\Controller\Plugin;

use yimaSettings\Service\Settings;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class settingHelper
 *
 * @package yimaSettings\Controller\Plugin
 */
class settingHelper extends AbstractPlugin
    implements ServiceLocatorAwareInterface
{
    /**
     * @var \Zend\Mvc\Controller\PluginManager
     */
    protected $serviceLocator;

    /**
     * Invoke as a functor
     *
     * @return Settings
     */
    public function __invoke()
    {
        $sm = $this->getServiceManager();

        $settService = $sm->get('yimaSettings');

        return $settService;
    }

    /**
     * Get Service Manager
     *
     * @return \Zend\ServiceManager\ServiceManager
     */
    protected function getServiceManager()
    {
        $sm = $this->getServiceLocator()->getServiceLocator();

        return $sm;
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }

    /**
     * Get service locator
     *
     * @return \Zend\Mvc\Controller\PluginManager
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
