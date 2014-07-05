<?php
namespace yimaSettings\Model;

use yimaSettings\Service\Settings\SettingEntity;
use yimaSettings\Service\Settings\SettingHydrator;
use Zend\Config\Writer\PhpArray as PhpArrayWriter;

/**
 * Class Settings
 *
 * @package yimaSettings\Model
 */
class SettingsModel implements SettingsModelInterface
{
    /**
     * @var SettingHydrator
     */
    protected $hydrator;

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
     * Load namespace data and hydrate new data in given entity
     *
     * @param string        $namespace Namespace
     * @param SettingEntity &$entity    Entity
     *
     * @return array Key/Value Data
     */
    public function load(SettingEntity &$entity)
    {
        $namespace = $entity->getNamespace();
        $data = $this->loadWithNamespace($namespace);
        $entity->getHydrator()->hydrate($data, $entity);

        return $data;
    }

    /**
     * Load Entity Properties for a namespace
     *
     * @param string $namespace Namespace
     *
     * @return array
     */
    public function loadWithNamespace($namespace)
    {
        $return = array();

        $file = realpath(__DIR__.DS. '../../../data'.DS. $namespace.'.config.php');
        if (file_exists($file)) {
            $return = include_once($file);
        }

        return $return;
    }
}
