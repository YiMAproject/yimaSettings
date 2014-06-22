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
class Settings implements SettingsInterface
{
    /**
     * @var SettingHydrator
     */
    protected $hydrator;

    /**
     * Save Entity Properties for a section
     * section is sets of related configs that collect together
     *
     * @param string        $namespace Namespace
     * @param SettingEntity $entity    Entity
     *
     * @return boolean
     */
    public function updateWithNamespace($namespace, SettingEntity $entity)
    {
        $writer = new PhpArrayWriter();

        $file = __DIR__.DS. '../../../config'.DS. $namespace.'.config.php';
        if (file_exists($file)) {
            // avoid permission denied for files on some servers
            unlink($file);
        }

        $writer->toFile(
            $file,
            $this->getHydrator()->extract($entity)
        );

        return true;
    }

    /**
     * Load namespace data and hydrate new data in given entity
     *
     * @param string        $namespace Namespace
     * @param SettingEntity $entity    Entity
     *
     * @return array Key/Value Data
     */
    public function getNamespaceDataIntoEntity($namespace, SettingEntity $entity)
    {
        $data = $this->getDataWithNamespace($namespace);
        $this->getHydrator()->hydrate($data, $entity);

        return $data;
    }

    /**
     * Load Entity Properties for a section
     *
     * @param string $namespace Namespace
     *
     * @return array
     */
    public function getDataWithNamespace($namespace)
    {
        $return = array();

        $file = realpath(__DIR__.DS. '../../../config'.DS. $namespace.'.config.php');
        if (file_exists($file)) {
            $return = include_once($file);
        }

        return $return;
    }

    /**
     * Get Hydrator
     *
     * @return SettingHydrator
     */
    protected function getHydrator()
    {
        if (!$this->hydrator) {
            $this->hydrator = new SettingHydrator();
        }

        return $this->hydrator;
    }
}