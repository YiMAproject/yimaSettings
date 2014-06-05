<?php
namespace yimaSettings\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Settings
 *
 * @package yimaSettings\Service
 */
class Settings implements serviceLocatorAwareInterface
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $sm;

    /**
     * @var array[SettingEntity]
     */
    protected $settings = array();

    /**
     * Get Setting
     *
     * @param string $section
     *
     * @throws \Exception
     * @return Settings\SettingEntity
     */
    public function getSetting($section = 'defaults')
    {
        if (! isset($this->settings[$section])) {
            $conf = $this->getConfig();
            if (!isset($conf[$section])) {
                throw new \Exception("There is no configuration for '{$section}' on Yima Settings.");
            }

            $conf = $conf[$section];
            $this->settings[$section] = new Settings\SettingEntity($conf);
        }

        return $this->settings[$section];
    }

    /**
     * Get Yima Settings Configuration Settings
     *
     * @return array|object
     */
    protected function getConfig()
    {
        /** @var $sm \Zend\ServiceManager\ServiceManager */
        $sm   = $this->getServiceLocator();
        $conf = $sm->get('config');

        $conf = (isset($conf['yima-settings'])) ? $conf['yima-settings'] : array();

        return $conf;
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->sm = $serviceLocator;

        return $this;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->sm;
    }
}
