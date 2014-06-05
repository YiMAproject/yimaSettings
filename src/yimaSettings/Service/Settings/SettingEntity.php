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
     * Data options to creating form
     * @var array
     */
    protected $formFactory;

    /**
     * @var AbstractHydrator
     */
    protected $formHydrator;

    /**
     * Construct
     *
     * @param array|traversable|toArray Object $data
     */
    public function __construct($data = array())
    {
        parent::__construct($data);

        $this->setStrictMode();
    }

    /**
     * Extract Data into key => value array
     * and collect form data options to form generator
     * @see $this->getForm();
     *
     * @param  $data
     *
     * @return \Traversable | array
     */
    protected function extractData($data)
    {
        if (is_object($data)) {
            if (method_exists($data, 'toArray')) {
                $data = call_user_func(array($data, 'toArray'), $data);
            }
        }

        if (! is_array($data) && ! $data instanceof Traversable   ) {
            throw new \Exception(__METHOD__ . ' expects an array or Traversable set of options');
        }

        $return = array();
        foreach ($data as $key => $value) {
            if ($value instanceof Traversable) {
                $value = (array) $value;
            }

            $return[$key] = (isset($value['value'])) ? $value['value'] : null;

            // collect form elements
            if (isset($value['element'])) {
                // form element data
                $label = (isset($value['label'])) ? $value['label'] : null;

                $value = $value['element'];
                if ($label) {
                    // set label for element
                    if (!isset($value['options']) && !is_array($value['options'])) {
                        $value['options'] = array();
                    }
                    $value['options'] = ArrayUtils::merge($value['options'], array('label' => $label));
                }
                $value['name'] = $key; // we need name at least
                $this->formFactory[] = $value;
            }
        }

        return $return;
    }

    /**
     * Get Form generated from entity
     *
     * @return \Zend\Form\Form
     */
    public function getForm()
    {
        $form = new \Zend\Form\Form();

        foreach($this->formFactory as $elem) {
            $form->add($elem);
        }

        // form hydrator that we can bind settingEntity into form
        $hydrator = $this->getFormHydrator();
        $form->setHydrator($hydrator);

        // bind setting values to form
        $form->bind($this);

        return $form;
    }

    /**
     * Get form hydrator
     * with hydrator we can set values from SettingEntity into form
     *
     * @return SettingHydrator
     */
    protected function getFormHydrator()
    {
        if (!$this->formHydrator) {
            $this->formHydrator = new SettingHydrator();
        }

        return $this->formHydrator;
    }
}