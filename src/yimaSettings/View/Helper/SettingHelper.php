<?php
namespace yimaSettings\View\Helper;

use yimaSettings\Service\Settings;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;

/**
 * Class settingHelper
 *
 * @package yimaSettings\Controller\Plugin
 */
class settingHelper extends AbstractHelper
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
