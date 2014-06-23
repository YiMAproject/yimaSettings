<?php
namespace yimaSettings\Controller\Plugin;

use yimaSettings\Service\Settings\SettingEntity;
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
     * @var SettingEntity
     */
    protected $entity;

    /**
     * @var string
     */
    protected $section;

    /**
     * Invoke as a functor
     *
     * @return SettingEntity
     */
    public function __invoke($namespace = 'defaults')
    {
        $this->section = $namespace;

        $sm = $this->getServiceManager();
        /** @var $entitySett SettingEntity */
        $entitySett   = $sm->get('yimaSettings')
            ->getSetting($namespace);

        $this->entity = $entitySett;

        return $this;
    }

    // PROXY TO ENTITY ---

    /**
     * Proxy Call to EntitySetting
     *
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->entity, $method), $args);
    }

    /**
     * Proxy Get To EntitySetting
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return call_user_func_array(array($this->entity, 'get'), array($name));
    }

    /**
     * Proxy Set To EntitySetting
     *
     * @param $name
     * @param $vale
     *
     * @return mixed
     */
    public function __set($name, $vale)
    {
        return call_user_func_array(array($this->entity, 'set'), array($name, $vale));
    }
    // --- END PROXY TO ENTITY

    /**
     * Save Last Modified Entity
     *
     * @return $this
     */
    public function save()
    {
        $sm = $this->getServiceManager();
        $sm->get('yimaSettings.Model.Settings')
            ->save($this->entity);

        return $this;
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
