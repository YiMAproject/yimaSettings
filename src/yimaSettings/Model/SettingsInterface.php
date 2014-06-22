<?php
namespace yimaSettings\Model;

use yimaSettings\Service\Settings\SettingEntity;

/**
 * Interface SettingsInterface
 *
 * @package yimaSettings\Model
 */
interface SettingsInterface
{
    /**
     * Save Entity Properties for a section
     * section is sets of related configs that collect together
     *
     * @param string        $namespace Namespace
     * @param SettingEntity $entity    Entity
     *
     * @return boolean
     */
    public function updateWithNamespace($namespace, SettingEntity $entity);

    /**
     * Load namespace data and hydrate new data in given entity
     *
     * @param string        $namespace Namespace
     * @param SettingEntity $entity    Entity
     *
     * @return array Key/Value Data
     */
    public function getNamespaceDataIntoEntity($namespace, SettingEntity $entity);

    /**
     * Load Entity Properties for a section
     *
     * @param string $namespace Namespace
     *
     * @return array
     */
    public function getDataWithNamespace($namespace);
}