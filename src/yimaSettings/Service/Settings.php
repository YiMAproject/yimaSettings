<?php
namespace yimaSettings\Service;
use yimaSettings\Entity\SettingEntity;
use yimaSettings\Service\Settings\SettingsStorage;
use yimaSettings\Service\Settings\SettingsStorageInterface;

/**
 * Class Settings
 *
 * @package yimaSettings\Service
 */
class Settings
{
    /**
     * @var array[SettingEntity]
     */
    protected $settings = array();

    /**
     * @var array
     */
    protected $configs;

    /**
     * @var SettingsStorageInterface
     */
    protected $storage;

    protected $latestEntity = array();

    /**
     * Construct
     *
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    /**
     * Get Setting for specific namespace
     *
     * note: create an entity from setting option and replace
     *       default setting values with data saved in model.
     *
     * @param string $namespace
     *
     * @throws \Exception
     * @return SettingEntity
     */
    public function get($namespace = 'general')
    {
        return $this->__get($namespace);
    }

    /**
     * Magic Method
     *
     * @param string $namespace
     *
     * @throws \Exception
     * @return \Poirot\Dataset\Entity|SettingEntity
     */
    public function __get($namespace)
    {
        $namespace = strtolower($namespace);

        if (! isset($this->settings[$namespace])) {
            $conf = $this->configs;
            if (!isset($conf[$namespace])) {
                throw new \Exception("There is no configuration for '{$namespace}' on Yima Settings.");
            }

            // set namespace from config array key
            $conf   = array_merge($conf[$namespace], array('namespace' => $namespace));

            $entity = SettingEntity::factory($conf);

            $this->settings[$namespace] = $entity;
        }

        /** @var $entity SettingEntity */
        $entity = $this->settings[$namespace];
        // replace saved config with defaults
        $this->getStorage()->load($entity);

        return $entity;
    }

    /**
     * Has Specific Setting for a Namespace?
     *
     * @param string $namespace Setting Namespace, exp. General
     *
     * @return bool
     */
    public function hasSetting($namespace)
    {
        return (isset($this->configs[$namespace]) && is_array($this->configs[$namespace]));
    }

    /**
     * Get all registered settings section names
     *
     * @return array
     */
    public function getSettingsList()
    {
        return array_keys($this->configs);
    }

    /**
     * Get Entity Values Storage To Save And Load Data
     *
     * @return SettingsStorage|SettingsStorageInterface
     */
    protected function getStorage()
    {
        if (!$this->storage) {
            $this->storage = new SettingsStorage();
        }

        return $this->storage;
    }
}
