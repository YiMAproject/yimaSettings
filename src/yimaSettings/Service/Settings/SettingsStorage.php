<?php
namespace yimaSettings\Service\Settings;

use yimaSettings\Entity\SettingEntity;
use Zend\Config\Writer\PhpArray as PhpArrayWriter;


class SettingsStorage implements SettingsStorageInterface
{
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

        $writer = new PhpArrayWriter();

        $file = __DIR__.DS. '../../../data'.DS. $namespace.'.config.php';
        if (file_exists($file)) {
            // avoid permission denied for files on some servers
            unlink($file);
        }

        $writer->toFile(
            $file,
            $entity->getHydrator()->extract($entity)
        );

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
        $data = $this->getNamespaceStoredData($namespace);
        $entity->getHydrator()->hydrate($data, $entity);

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

        $file = realpath(__DIR__.DS. '../../../data'.DS. $namespace.'.config.php');
        if (file_exists($file)) {
            $return = include_once($file);
        }

        return $return;
    }
}
