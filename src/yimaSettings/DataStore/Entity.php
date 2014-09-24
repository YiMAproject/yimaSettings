<?php
namespace yimaSettings\DataStore;

use yimaSettings\DataStore\Entity\ConverterInterface;

class Entity
{
    const DEFAULT_NONE_VALUE = null;

    /**
     * Get Property
     *
     * @param $prop
     * @param null $default Default Empty None Value
     *
     * @throw Exception\PropertyNotFoundException
     * @return mixed
     */
    public function get($prop, $default = self::DEFAULT_NONE_VALUE)
    {

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

    }

    /**
     * Delete a property
     *
     * @param string $prop Property
     *
     * @throw Exception\PropertyNotFoundException
     * @return $this
     */
    public function del($prop)
    {

    }

    /**
     * Get All Properties Keys
     *
     * @return array
     */
    public function keys()
    {

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
     * @return mixed
     */
    public function getAs(ConverterInterface $converter)
    {
        return $converter->from($this)
            ->convert();
    }
}
