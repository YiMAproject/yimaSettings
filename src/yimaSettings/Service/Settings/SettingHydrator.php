<?php
namespace yimaSettings\Service\Settings;

use Zend\Stdlib\Hydrator\AbstractHydrator;

/**
 * Class SettingHydrator
 * to bind settingEntity into form
 *
 * @package yimaSettings\Service\Settings
 */
class SettingHydrator extends AbstractHydrator
{
    /**
     * Extract values from an Entity object 
     *
     * @param SettingEntity $object
     *
     * @return array
     */
    public function extract($object)
    {
        if (!$object instanceof SettingEntity) {
            throw new \Exception(
                sprintf(
                    '%s expects the provided $object to be a SettingEntity instance.', __METHOD__
                )
            );
        }

        return $object->getArrayCopy();
    }

    /**
     * Hydrate an Entity object
     *
     * @param  array $data
     * @param  object $object
     * @return object
     * @throws \Exception for a non-object $object
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof SettingEntity) {
            throw new \Exception(
                sprintf(
                    '%s expects the provided $object to be a SettingEntity instance.', __METHOD__
                )
            );
        }

        $object->setProperties($data);
        
        return $object;
    }
}
