<?php
namespace yimaSettings\Model;

use yimaSettings\Service\Settings\SettingEntity;
use Zend\Config\Reader\Xml as XmlReader;
use Zend\Config\Writer\Xml as XmlWriter;

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
        $xml = new XmlWriter();

        $file = realpath(__DIR__.DS. '../../../config'.DS. $section.'.xml');

        $xml->toFile($file, $entity->getArrayCopy());

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
        $xml = new XmlReader();

        $file = realpath(__DIR__.DS. '../../../config'.DS. $section.'.xml');

        return $xml->fromFile($file);
    }
}