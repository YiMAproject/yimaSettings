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
     * @param $section
     * @param SettingEntity $entity
     *
     * @return mixed
     */
    public function save($section, SettingEntity $entity);

    /**
     * Load Entity Properties for a section
     *
     * @param $section
     *
     * @return array
     */
    public function load($section);
}