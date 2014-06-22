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
     * Get Setting for specific part
     *
     * note: create an entity from setting option and replace
     *       default setting values with data saved in model.
     *
     * @param string $namespace
     *
     * @throws \Exception
     * @return Settings\SettingEntity
     */
    public function getSetting($namespace = 'defaults')
    {
        if (! isset($this->settings[$namespace])) {
            $conf = $this->getMergedConfig();
            if (!isset($conf[$namespace])) {
                throw new \Exception("There is no configuration for '{$namespace}' on Yima Settings.");
            }

            /*
             * 'namespace' => array (
             *      'setting_opt1'   => array(
                        'value' => 'http://ir.linkedin.com/in/payamnaderi',
                        'label' => 'Your Linkedin Address',
                        # form element
                        'element' => array(
                            'type' => 'Zend\Form\Element\Url',
                            'attributes' => array(
                                'required' => 'required',
                            ),
                            // ...
                        ),
                    ),
                ),
             */
            $namespaceSettings = $conf[$namespace];
            $settEntity        = new Settings\SettingEntity($namespaceSettings);

            // replace saved config with defaults {
            $model = $this->getServiceLocator()->get('yimaSettings.Model.Settings');
            $model->getNamespaceDataIntoEntity($namespace, $settEntity);
            // ... }

            $this->settings[$namespace] = $settEntity;
        }

        return $this->settings[$namespace];
    }

    /**
     * Get Yima Settings Conf. from Application
     * Merged Config
     *
     * @return array|object
     */
    protected function getMergedConfig()
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
