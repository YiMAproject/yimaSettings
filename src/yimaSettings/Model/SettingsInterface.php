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
     * @param $namespace
     * @param SettingEntity $entity
     *
     * @return mixed
     */
    public function updateWithNamespace($namespace, SettingEntity $entity);

    /**
     * Load Entity Properties for a section
     *
     * @param $namespace
     *
     * @return array
     */
    public function getDataWithNamespace($namespace);
}