<?php
namespace yimaSettings\DataStore\FileStore;

use yimaSettings\DataStore\Collection\CollectionInterface;
use yimaSettings\DataStore\DataStoreInterface;

class FileDataStore implements DataStoreInterface
{
    /**
     * Collections File Extension
     */
    const EXT = 'config.php';

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string Dir Path To Storage Folder
     */
    protected $storage_folder;

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
        $this->prefix = (string) $prefix;

        return $this;
    }

    /**
     * Get Prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Pick a prefixed Collection
     *
     * @return CollectionInterface
     */
    public function using($collection)
    {
        $collection = new FileCollection($collection);
        $collection->setStorageFolder($this->storage_folder);

        return $collection;
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
        foreach($this->getCollections() as $col) {
            if (strtolower($collection) == strtolower($col))
                return true;
        }

        return false;
    }

    /**
     * Get All Collections Within Prefixed DataStore
     *
     * @return array
     */
    public function getCollections()
    {
        $collections = [];
        $pattern = $this->storage_folder.DIRECTORY_SEPARATOR.'*.'.self::EXT;
        foreach (glob($pattern) as $filename) {
            $collections[] = ucfirst(strtolower(str_replace('.'.self::EXT, '', basename($filename))));
        }

        return $collections;
    }

    // ----------------------------------------------------------------------------

    /**
     * Set Dir Path To Storage Folder
     *
     * @param string $dirpath Dir Path
     *
     * @return $this
     */
    public function setStorageFolder($dirpath)
    {
        $dirpath = rtrim($dirpath, DIRECTORY_SEPARATOR);
        $dirpath = rtrim($dirpath, '/');

        if ($this->getPrefix())
            // append prefix to storage
            $dirpath .= DIRECTORY_SEPARATOR.$this->getPrefix();

        if (!is_dir($dirpath))
            mkdir($dirpath, 0777, true);

        $this->storage_folder = $dirpath;

        return $this;
    }
}
