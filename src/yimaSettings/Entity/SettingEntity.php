<?php
namespace yimaSettings\Entity;

use Poirot\Dataset\Entity;
use Zend\Stdlib\ArrayUtils;

/**
 * Class SettingEntity
 *
 * @package yimaSettings\Service\Settings
 */
class SettingEntity extends Entity
{
    /**
     * Namespace of this entity used by storage to retrieve data
     *
     * @var string
     */
    protected $namespace;

    /**
     * Hydrate entity values
     *
     * @var SettingEntityHydrator
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
            $this->namespace = 'general';
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
     * @return SettingEntityHydrator
     */
    public function getHydrator()
    {
        if (!$this->hydrator) {
            $this->hydrator = new SettingEntityHydrator();
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
        return ($data instanceof SettingItemsEntity);
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
            $value = new SettingItemsEntity($value);
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

        /** @var $ent \yimaSettings\Entity\SettingItemsEntity */
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
        $form->setHydrator(
            $this->getHydrator()
        );

        // bind setting values to form
        $form->bind($this);

        // $form->prepare();

        return $form;
    }
}