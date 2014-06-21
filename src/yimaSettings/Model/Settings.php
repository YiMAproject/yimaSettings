<?php
namespace yimaSettings\Model;

use yimaSettings\Service\Settings\SettingEntity;
use Zend\Config\Writer\PhpArray as PhpArrayWriter;

/**
 * Class Settings
 *
 * @package yimaSettings\Model
 */
class Settings implements SettingsInterface
{
    /**
     * Save Entity Properties for a section
     * section is sets of related configs that collect together
     *
     * @param $namespace
     * @param SettingEntity $entity
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

        $writer->toFile($file, $entity->getArrayCopy());

        return true;
    }

    /**
     * Load Entity Properties for a section
     *
     * @param $namespace
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
}