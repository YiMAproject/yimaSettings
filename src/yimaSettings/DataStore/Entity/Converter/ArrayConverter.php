<?php
namespace yimaSettings\DataStore\Entity\Converter;

use yimaSettings\DataStore\Entity\ConverterInterface;
use yimaSettings\DataStore\Entity;

class ArrayConverter implements ConverterInterface
{
    /**
     * @var array
     */
    protected $properties;

    /**
     * Construct
     *
     * @param array $props
     */
    public function __construct(array $props = array())
    {
        $this->setProperties($props);
    }

    /**
     * Fill Converter Props. With Entity Object
     *
     * @param Entity $entity Entity
     *
     * @return $this
     */
    public function from(Entity $entity)
    {
        $props = [];
        foreach($entity->keys() as $key) {
            $props[$key] = $entity->get($key);
        }

        $this->setProperties($props);

        return $this;
    }

    /**
     * Set Properties From Converter To Entity
     *
     * @param Entity $entity Entity Object
     *
     * @return $this
     */
    public function into(Entity $entity)
    {
        foreach($this->properties as $key => $val) {
            $entity->set($key, $val);
        }

        return $this;
    }

    /**
     * Output Converter Props. as desired manipulated data struct.
     *
     * @return mixed
     */
    public function convert()
    {
        return $this->properties;
    }

    /**
     * Set Properties with type used by converter
     * : it can be array or any kind of data
     *   related to converter strategy
     *
     * @param mixed $properties Properties
     *
     * @return $this
     */
    public function setProperties($properties)
    {
        if (!is_array($properties))
            throw new \InvalidArgumentException(
                sprintf('Properties must be array but %s given.', gettype($properties))
            );

        $this->properties = $properties;

        return $this;
    }
}
