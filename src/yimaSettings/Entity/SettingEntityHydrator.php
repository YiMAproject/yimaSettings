<?php
namespace yimaSettings\Entity;

use Poirot\Dataset\Entity;
use Zend\Stdlib\Hydrator\AbstractHydrator;

/**
 * Class SettingEntityHydrator
 * to bind settingEntity into form
 *
 * @package yimaSettings\Service\Settings
 */
class SettingEntityHydrator extends AbstractHydrator
{
    /**
     * Extract values from an Entity object 
     *
     * @param SettingEntity $entity
     *
     * @return array
     */
    public function extract($entity)
    {
        if (!$entity instanceof SettingEntity) {
            throw new \Exception(
                sprintf(
                    '%s expects the provided $object to be a SettingEntity instance.', __METHOD__
                )
            );
        }

        // Get only Key and Value Pair of data from SettingEntity
        $entity = clone $entity; // remain filters from orig. entity
        $entity->clearFilters();

        $return = array();
        /** @var $data \yimaSettings\Service\Settings\SettingEntityItems */
        foreach($entity as $key => $data) {
            $data = clone $data;   // remain filters from orig. entity
            $data->clearFilters(); // clear filters

            $value = $data->value;
            $return[$key] = ($value instanceof Entity) ? $value->getArrayCopy() : $value;
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
