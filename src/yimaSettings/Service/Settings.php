<?php
namespace yimaSettings\Service;
use Poirot\Dataset\FilterObjectInterface;
use yimaSettings\Entity\SettingEntity;
use yimaSettings\Entity\SettingItemsEntity;
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

    /**
     * Store latest entity fetched that we can save
     * those entity for a part of code that request save
     *
     * @var array
     */
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
     * @return \Poirot\Dataset\Entity | SettingEntity
     */
    public function __get($namespace)
    {
        $namespace = $this->normalizeKey($namespace);

        if (! isset($this->settings[$namespace])) {
            $conf = array();
            foreach ($this->configs as $key => $cnf) {
                if ($this->normalizeKey($key) == $namespace) {
                    $conf = $cnf;
                    break;
                }
            }

            if (!isset($conf)) {
                throw new \Exception("There is no configuration for '{$namespace}' on Yima Settings.");
            }

            // set namespace from config array key
            $conf   = array_merge($conf, array('namespace' => $namespace));
            $entity = SettingEntity::factory($conf);

            // replace saved config with defaults
            $storage = $this->getStorage();
            $entity->addFilter('*',
                new \Poirot\Dataset\EntityFilterCallable(array(
                        'callable' => function($filterObject) use ($storage, $namespace) {
                            /** @var $filterObject FilterObjectInterface */
                            $ve     = $filterObject->getValue();
                            /** @var $ve SettingItemsEntity */
                            if (!$ve->hasFilter('value', 'load.ondemand')) {
                                $ve->addFilter('value', new \Poirot\Dataset\EntityFilterCallable(
                                    array(
                                        'callable' => function($fo) use ($storage, $filterObject, $namespace) {
                                            // load entity data ... {
                                            // previous loaded
                                            $getPro = $filterObject->getProperty('__get');
                                            $propName    = '__'.$namespace.'__loaded';
                                            $loadedProps = $filterObject->getProperty($propName);
                                            $loadedProps = ($loadedProps) ?: array();
                                            if (!array_key_exists($getPro, $loadedProps)) {
                                                $entity = $filterObject->getProperty('entity');
                                                $storage->load($entity);
                                                $loadedProps = array_merge($loadedProps, array($getPro => true));
                                                $filterObject->setProperty($propName, $loadedProps);

                                                $settingsItem = clone $entity->{$getPro};
                                                $settingsItem->clearFilters();
                                                $fo->setValue($settingsItem->get('value'));
                                            }
                                            // ... }
                                        },
                                        'name' => 'load.ondemand',
                                        'priority' => 10000,
                                    )
                                ));
                            }
                        },
                        'name' => 'load.ondemand.value',
                        'priority' => 10000,
                    )
                )
            );

            $this->settings[$namespace] = $entity;
        }

        /** @var $entity SettingEntity */
        $entity = $this->settings[$namespace];

        // store entity
        // note: we want each part of codes only save own manipulated entities data
        //       exp. if you manipulate some data in "index.php" and save on controller.php
        //            nothing will happens
        $callerId = $this->getCallerId();
        $this->latestEntity[$callerId] = $entity;

        return $entity;
    }

    /**
     * Generate a hash key from script who request call to this class
     *
     * @return string
     */
    protected function getCallerId()
    {
        list($t) = $trace = debug_backtrace(false);
        foreach($trace as $t) {
            if ($t['file'] != __FILE__) {
                break;
            }
        }

        $return = array(
            $t['file'],
            $t['class']
        );

        return md5(serialize($return));
    }

    /**
    * Save Last Modified Entity
    *
    * @return boolean
    */
    public function save($entity = null)
    {
        $callerID = $this->getCallerId();
        if (!$entity) {
            $entity   = isset($this->latestEntity[$callerID])
                ? $this->latestEntity[$callerID]
                : false;
        }

        if ($entity === false) {
            throw new \Exception('No any setting yet loaded.');
        } elseif (!$entity instanceof SettingEntity) {
            throw new \Exception(
                sprintf(
                    'Entity must instance of "SettingEntity" but "%s" given.'
                    , is_object($entity) ? get_class($entity) : gettype($entity)
                )
            );
        }

        return $this->getStorage()->save($entity);
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
        $namespace = $this->normalizeKey($namespace);

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

    /**
     * Normalize namespaces
     *
     * @param string $key Key to normalize
     *
     * @return string
     */
    protected function normalizeKey($key)
    {
        $key = strtolower($key);

        return $key;
    }
}
