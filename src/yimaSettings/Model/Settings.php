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

    public function save($section, SettingEntity $entity)
    {
        $xml = new XmlWriter();

        $file = realpath(__DIR__.DS. '../../../config'.DS. $section.'.xml');

        return $xml->toFile($file, $entity->getArrayCopy());
    }

    public function load($section)
    {
        $xml = new XmlReader();

        $file = realpath(__DIR__.DS. '../../../config'.DS. $section.'.xml');

        return $xml->fromFile($file);
    }
}