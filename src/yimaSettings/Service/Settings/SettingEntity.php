<?php
namespace yimaSettings\Service\Settings;

use Poirot\Dataset\Entity;
use Traversable;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\Hydrator\AbstractHydrator;

/**
 * Class SettingEntity
 *
 * @package yimaSettings\Service\Settings
 */
class SettingEntity extends Entity
{
    /**
     * Namespace of this entity used by model to retrieve data
     *
     * @var string
     */
    protected $namespace;

    /**
     * @var SettingHydrator
     */
    protected $hydrator;

    /**
     * Get namespace name
     *
     * @return string
     */
    public function getNamespace()
    {
        if (!$this->namespace) {
            $this->namespace = 'default';
        }

        return $this->namespace;
    }

    /**
     * Set namespace
     *
     * @param $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = (string) $namespace;
    }

    /**
     * Get Hydrator
     * note: used to manipulate and extract data of entity
     *       good combination with models
     *
     * @return SettingHydrator
     */
    public function getHydrator()
    {
        if (!$this->hydrator) {
            $this->hydrator = new SettingHydrator();
        }

        return $this->hydrator;
    }

    /**
     * Validate Entity Data
     *
     * @param mixed $data Data
     *
     * @return bool
     */
    public function isValidEntityData($data)
    {
        return ($data instanceof SettingEntityItems);
    }

    /**
     * Check for validated Entity data
     *
     * note: We are using check method that extended
     *       classes can throw own exception message
     *
     * @param mixed $data Data
     *
     * @return bool true
     */
    protected function checkValidEntityData($data)
    {
        if (!$this->isValidEntityData($data)) {
            throw new \Exception(
                sprintf(
                    'Invalid Entity Data "%s". Data must be instance of "SettingEntityItems".',
                    (is_object($data)) ? get_class($data) : gettype($data)
                )
            );
        }
    }

    /**
     * Set entity value
     *
     * an entity can have a setter method:
     * variable_name ===> setVariableName()
     *
     * @param string $name
     * @param mixed $value
     *
     * @return void
     */
    public function __set($key, $value)
    {
        if (is_array($value)) {
            // we sure that data array is valid by construct -
            // desired entity
            $value = new SettingEntityItems($value);
        }

        parent::__set($key, $value);
    }

    /**
     * Get Form generated from entity
     *
     * @return \Zend\Form\Form
     */
    public function getForm()
    {
        $form = new \Zend\Form\Form();

        /** @var $ent \yimaSettings\Service\Settings\SettingEntityItems */
        foreach($this as $key => $ent) {
            $ent = $ent->getArrayCopy();

            // collect form elements {
            if (isset($ent['element'])) {
                /* @note: Values are set from hydrator */

                // form element data
                $label = (isset($ent['label'])) ? $ent['label'] : null;

                $element = $ent['element'];
                if ($label) {
                    // set label for element
                    if (!isset($element['options']) && !is_array($element['options'])) {
                        $element['options'] = array();
                    }
                    $element['options'] = ArrayUtils::merge(
                        $element['options'],
                        array('label' => $label)
                    );
                }
                $element['name'] = $key; // we need name at least

                $form->add($element);
            }
            // ... }
        }

        // form hydrator that we can bind settingEntity into form
        $form->setHydrator(new SettingHydrator());

        // bind setting values to form
        $form->bind($this);

        // $form->prepare();

        return $form;
    }
}