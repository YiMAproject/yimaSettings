<?php
namespace yimaSettings\Service\Settings;

use yimaSettings\Entity\SettingEntity;

/**
 * Interface SettingsModelInterface
 *
 * @package yimaSettings\Model
 */
interface SettingsStorageInterface
{
    /**
     * Save Entity Value Properties for a section
     * section is sets of related configs that collect together
     *
     * @param string        $namespace Namespace
     * @param SettingEntity $entity    Entity
     *
     * @return boolean
     */
    public function save(SettingEntity $entity);

    /**
     * Load namespace data and hydrate new data in given entity
     *
     * @param string        $namespace Namespace
     * @param SettingEntity &$entity    Entity
     *
     * @return array Key/Value Data
     */
    public function load(SettingEntity $entity);
}