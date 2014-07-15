<?php
namespace yimaSettings\Service\Settings;

use yimaSettings\Entity\SettingEntity;
use Zend\Config\Writer\PhpArray as PhpArrayWriter;

/**
 * Class SettingsStorage
 *
 * @package yimaSettings\Service\Settings
 */
class SettingsStorage implements SettingsStorageInterface
{
    /**
     * @var array Internal Cache to avoid loading namespaces data again
     */
    protected $internalCache = array();

    /**
     * Save Entity Properties for a section
     * section is sets of related configs that collect together
     *
     * @param SettingEntity $entity Entity
     *
     * @return boolean
     */
    public function save(SettingEntity $entity)
    {
        $namespace = $entity->getNamespace();

        // replace internal cache with new data
        $data = $entity->getHydrator()->extract($entity);
        $this->internalCache[$namespace] = $data;

        // save entity data
        $file = __DIR__.DS. '../../../../data'.DS. $namespace.'.config.php';
        if (file_exists($file)) {
            // avoid permission denied for files on some servers
            unlink($file);
        }

        $writer = new PhpArrayWriter();
        $writer->toFile($file, $data);

        return true;
    }

    /**
     * Load namespace value data and hydrate new data in given entity
     *
     * @param string        $namespace Namespace
     * @param SettingEntity &$entity    Entity
     *
     * @return array Key/Value Data
     */
    public function load(SettingEntity $entity)
    {
        $namespace = $entity->getNamespace();
        if (isset($this->internalCache[$namespace])) {
            // load internal cache data
            return $this->internalCache[$namespace];
        }

        $data = $this->getNamespaceStoredData($namespace);
        $entity->getHydrator()->hydrate($data, $entity);

        $this->internalCache[$namespace] = $data;

        return $entity;
    }

    /**
     * Load Entity Stored Value Properties for a namespace
     *
     * @param string $namespace Namespace
     *
     * @return array
     */
    protected function getNamespaceStoredData($namespace)
    {
        $return = array();

        if (isset($this->internalCache[$namespace])) {

        }

        $file = realpath(__DIR__.DS. '../../../../data'.DS. $namespace.'.config.php');
        if (file_exists($file)) {
            $return = include($file);
        }

        return $return;
    }
}
