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
    public function save($section, SettingEntity $entity);

    public function load($section);
}