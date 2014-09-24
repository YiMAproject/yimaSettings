<?php
namespace yimaSettings\DataStore\Entity;


use yimaSettings\DataStore\Entity;

interface ConverterInterface
{
    /**
     * Fill Converter Props. With Entity Object
     *
     * @param Entity $entity Entity
     *
     * @return $this
     */
    public function from(Entity $entity);

    /**
     * Set Properties From Converter To Entity
     *
     * @param Entity $entity Entity Object
     *
     * @return $this
     */
    public function into(Entity $entity);

    /**
     * Output Converter Props. as desired manipulated data struct.
     *
     * @return mixed
     */
    public function convert();

    /**
     * Set Properties with type used by converter
     * : it can be array or any kind of data
     *   related to converter strategy
     *
     * @param mixed $properties Properties
     *
     * @return $this
     */
    public function setProperties($properties);
}
