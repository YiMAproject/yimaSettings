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
     * @param $section
     * @param SettingEntity $entity
     *
     * @return boolean
     */
    public function save($section, SettingEntity $entity)
    {
        $writer = new PhpArrayWriter();

        $file = __DIR__.DS. '../../../config'.DS. $section.'.config.php';
        if (!file_exists($file)) {

        }

        $writer->toFile($file, $entity->getArrayCopy());

        return true;
    }

    /**
     * Load Entity Properties for a section
     *
     * @param $section
     *
     * @return array
     */
    public function load($section)
    {
        $return = array();

        $file = realpath(__DIR__.DS. '../../../config'.DS. $section.'.config.php');
        if (file_exists($file)) {
            $return = include_once($file);
        }

        return $return;
    }
}