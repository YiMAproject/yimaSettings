<?php
namespace yimaSettings\DataStore;

use yimaSettings\DataStore\Collection\CollectionInterface;

class DataStoreAbstract implements DataStoreInterface
{
    /**
     * Set Storage Prefix
     *
     * ! to store multi independent data support
     *   like multi user
     *
     * @param string $prefix Prefix Storage
     *
     * @return $this
     */
    public function setPrefix($prefix)
    {
        // TODO: Implement setPrefix() method.
    }

    /**
     * Get Prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        // TODO: Implement getPrefix() method.
    }

    /**
     * Pick a prefixed Collection
     *
     * @return CollectionInterface
     */
    public function using($collection)
    {
        // TODO: Implement using() method.
    }

    /**
     * Data Store Has a Collection?
     *
     * ! determine current prefixed collection
     *
     * @param string $collection Collection Name
     *
     * @return boolean
     */
    public function hasCollection($collection)
    {
        // TODO: Implement hasCollection() method.
    }

    /**
     * Get All Collections Within Prefixed DataStore
     *
     * @return array
     */
    public function getCollections()
    {
        // TODO: Implement getCollections() method.
    }
}
