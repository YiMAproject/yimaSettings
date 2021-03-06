<?php
namespace yimaSettings\DataStore;

use yimaSettings\DataStore\Collection\CollectionInterface;

/**
 * Interface DataStoreInterface
 * : This is main interface that Setting Service
 *   use to fetch data from collections
 *
 *   (collections are app. settings individual sections)
 *   like general system settings, analytics settings, ...
 *
 * @package yimaSettings\DataStore
 */
interface DataStoreInterface
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
    public function setPrefix($prefix);

    /**
     * Get Prefix
     *
     * @return string
     */
    public function getPrefix();

    /**
     * Pick a prefixed Collection
     *
     * @return CollectionInterface
     */
    public function using($collection);

    /**
     * Data Store Has a Collection?
     *
     * ! determine current prefixed collection
     *
     * @param string $collection Collection Name
     *
     * @return boolean
     */
    public function hasCollection($collection);

    /**
     * Get All Collections Within Prefixed DataStore
     *
     * @return array
     */
    public function getCollections();
}
