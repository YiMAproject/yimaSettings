<?php
namespace yimaSettings\DataStore;

use yimaSettings\DataStore\Exception\PropertyNotFoundException;
use yimaSettings\DataStore\Entity\Converter\ArrayConverter;
use yimaSettings\DataStore\Entity\ConverterInterface;

class Entity
{
    const DEFAULT_NONE_VALUE = null;

    /**
     * Entity's items
     *
     * @var array
     */
    protected $properties = array();

    /**
     * Construct
     *
     * @param array $props
     */
    final public function __construct($props = array())
    {
        if (!empty($this->properties)) {
            // maybe we have some predefined props field in class
            // protected properties = array( .... );
            $props = array_merge($this->properties, $props);
        }

        $this->setFrom(new ArrayConverter($props));

        $this->conit();
    }

    /**
     * Init Entity after construct
     */
    protected function conit()
    {

    }

    /**
     * Get Property
     *
     * @param $prop
     * @param null $default Default Empty None Value
     *
     * @throws Exception\PropertyNotFoundException
     * @throw PropertyNotFoundException
     * @return mixed
     */
    public function get($prop, $default = self::DEFAULT_NONE_VALUE)
    {
        if (!$this->has($prop))
            throw new PropertyNotFoundException(
                sprintf('Property "%s" not found in entity.', $prop)
            );

        return $this->properties[$prop];
    }

    /**
     * Set Property with value
     *
     * @param string $prop  Property
     * @param mixed  $value Value
     *
     * @return $this
     */
    public function set($prop, $value = self::DEFAULT_NONE_VALUE)
    {
        $this->properties[$prop] = $value;

        return $this;
    }

    /**
     * Has Property
     *
     * @param string $prop Property
     *
     * @return boolean
     */
    public function has($prop)
    {
        return array_key_exists($prop, $this->properties);
    }

    /**
     * Delete a property
     *
     * @param string $prop Property
     *
     * @return $this
     */
    public function del($prop)
    {
        if (!$this->has($prop))
            unset($this->properties[$prop]);

        return $this;
    }

    /**
     * Get All Properties Keys
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->properties);
    }

    /**
     * Set Properties
     *
     * @param ConverterInterface $converter
     *
     * @return $this
     */
    public function setFrom(ConverterInterface $converter)
    {
        $converter->into($this);

        return $this;
    }

    /**
     * Get a copy of properties as hydrate structure
     *
     * @param Entity\ConverterInterface $converter
     * @return mixed
     */
    public function getAs(ConverterInterface $converter)
    {
        return $converter->from($this)
            ->convert();
    }
}
