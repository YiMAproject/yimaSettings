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

        // Get only Key and Value Pair of data from SettingEntity

        $return = array();
        /** @var $data \yimaSettings\Service\Settings\SettingEntityItems */
        foreach($object as $key => $data) {
            $return[$key] = $data->value;
        }

        return $return;
    }

    /**
     * Hydrate an Entity object
     *
     * @param  array $data
     * @param  SettingEntity $entity Entity Object
     *
     * @return SettingEntity
     *
     * @throws \Exception for a non-object $object
     */
    public function hydrate(array $data, $entity)
    {
        if (!$entity instanceof SettingEntity) {
            throw new \Exception(
                sprintf(
                    '%s expects the provided $object to be a SettingEntity instance.', __METHOD__
                )
            );
        }

        foreach($data as $key => $val) {
            if (isset($entity->{$key})) {
                // chane only values of presented entity members
                $entity->{$key}->value = $val;
            }
        }

        return $entity;
    }
}
