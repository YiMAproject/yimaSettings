<?php
namespace yimaSettings\Form;

use Zend\Form\Element;
use Zend\InputFilter\InputProviderInterface;

/**
 * Class ReadonlyElement
 *
 * @package yimaSettings\Form
 */
class ReadonlyElement extends Element implements InputProviderInterface
{
    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = array(
        'type' => 'text',
    );

    /**
     * Provide default input rules for this element
     *
     * Attaches an email validator.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        return array(
            'name' => $this->getName(),
            'required' => false,
            'filters' => array(
                array('name' => 'Zend\Filter\StringTrim'),
            ),
        );
    }
}
