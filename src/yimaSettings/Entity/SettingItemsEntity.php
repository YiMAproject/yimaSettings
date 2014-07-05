<?php
namespace yimaSettings\Entity;

use Poirot\Dataset\Entity;

/**
 * Class SettingEntityItems
 * note: each setting entity must be an extend from this class
 *       the setting validator check items against this.
 *
 * @package yimaSettings\Service\Settings
 */
class SettingEntityItems extends Entity
{
    /**
     * In Strict mode we cant add new Entity
     *
     * @var boolean
     */
    protected $strictMode = true;

    /**
     * Entity's items
     *
     * @var array
     */
    protected $properties = array(
        # used as default entity values
        'value' => null,
        'label' => 'Enter Value',
        # form element
        'element' => array(
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
            ),
            'options' => array(
                # these options was replaced by values from top
                # 'label' => 'label not set here',
                # 'value' => 'value not set from here because of hydrator',
            ),
        ),
        'options' => array(
            # merge with application config on bootstrap
            'merged_config' => false,
            'read_only'     => false,
        ),
    );

    /**
     * Set Element setter
     *
     * @param $element
     *
     */
    protected function setElement($element)
    {
        if (is_array($element)) {
            if(!isset($element['type'])) {
                throw new \Exception('Invalid element data, "type" attribute is required.');
            }
        } else {
            throw new \Exception('Invalid element data, must be an array.');
        }

        return $element;
    }
}
