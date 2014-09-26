<?php
namespace yimaSettings\DataStore\FileStore;

use Zend\Config\Writer\PhpArray as PhpArrayWriter;
use yimaSettings\DataStore\Collection\CollectionInterface;
use yimaSettings\DataStore\Entity;
use Zend\Stdlib\ArrayUtils;

class FileCollection implements CollectionInterface
{
    /**
     * @var string
     */
    protected $identity;

    /**
     * @var string Dir Path To Storage Folder
     */
    protected $storage_folder;

    /**
     * @var array Internal Cache to avoid loading Identity data again
     */
    protected $internalCache = array();

    /**
     * @var Array
     */
    protected $options = array();



    /**
     * Construct
     *
     * @param $identity
     */
    public function __construct($identity)
    {
        $this->setIdentity($identity);
    }

    /**
     * Set Identity
     * : use to separate collections row
     *
     * @param string $identity Identity
     *
     * @return $this
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * Get Identity
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Prepare Collection
     *
     * @throws \Exception
     * @return $this
     */
    public function prepare()
    {
        $file = $this->getStorageFilePathname();
        if (!file_exists($file))
            if (!$f = @fopen($file, 'w'))
                throw new \Exception(
                    sprintf('Can`t create file "%s".', $file)
                );
            else
                fclose($f);

        return $this;
    }

    /**
     * Fetch Identified Data Entity
     *
     * @throws \Exception
     * @return Entity
     */
    public function fetch()
    {
        $this->prepare();

        $identity = $this->getIdentity();
        if (isset($this->internalCache[$identity])) {
            // load internal cache data
            return $this->internalCache[$identity];
        }

        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            throw new \Exception($errstr, $errno);
        } , E_ALL);

        try {
            $data = include($this->getStorageFilePathname());
        } catch (\Exception $e) {
            throw $e;
        }
        restore_error_handler();

        // merge with default values
        $default_values = $this->getOption('default_values');
        if ($default_values)
            $data = ArrayUtils::merge($default_values, $data);

        $entity = new Entity();
        $entity->setFrom(new Entity\Converter\ArrayConverter($data));

        $this->internalCache[$identity] = $entity;

        return $entity;
    }

    /**
     * Save Data Entity In Collection
     * : it must use identity
     *
     * @param Entity $entity
     *
     * @throws \Exception Failed
     * @return $this
     */
    public function save(Entity $entity)
    {
        $data = $entity->getAs(new Entity\Converter\ArrayConverter());

        // replace internal cache with new data
        $identity = $this->getIdentity();
        $this->internalCache[$identity] = $entity;

        // save entity data
        $file = $this->getStorageFilePathname();
        if (file_exists($file)) {
            // avoid permission denied for files on some servers
            unlink($file);
        }

        $writer = new PhpArrayWriter();
        $writer->toFile($file, $data);

        return $this;
    }

    /**
     * Destroy Identity Collection And All Data
     *
     * @throws \Exception Failed
     * @return $this
     */
    public function destroy()
    {
        // $this->prepare();

        if (file_exists($this->getStorageFilePathname()))
            unlink($this->getStorageFilePathname());

        return $this;
    }

    // ------------------------------------------------------------------------

    /**
     * Set Option
     *
     * @param string $option Option
     * @param mixed $value Value
     *
     * @return $this
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;

        return $this;
    }

    /**
     * Get Option Value
     *
     * @param string $option Option Name
     *
     * @return mixed|null
     */
    public function getOption($option)
    {
        return $this->options[$option];
    }

    /**
     * Set Options
     *
     * @param array $options Associated Options
     *
     * @return $this
     */
    public function setOptions(array $options)
    {
        foreach ($options as $option => $value) {
            $this->setOption($option, $value);
        }

        return $this;
    }

    // ----------------------------------------------------------------------------

    /**
     * Set Dir Path To Storage Folder
     *
     * @param string $dirpath Dir Path
     *
     * @throws \Exception
     * @return $this
     */
    public function setStorageFolder($dirpath)
    {
        $dirpath = rtrim($dirpath, DIRECTORY_SEPARATOR);
        $dirpath = rtrim($dirpath, '/');

        $this->storage_folder = $dirpath;
        if (!is_dir($dirpath))
            throw new \Exception(
                sprintf('Directory "%s" does not exists.', $dirpath)
            );

        return $this;
    }

    /**
     * Get Storage Absolute File Path Name
     *
     * @return string
     */
    protected function getStorageFilePathname()
    {
        $storagePath = $this->storage_folder;
        $file = $storagePath . DIRECTORY_SEPARATOR . $this->getIdentity().'.'.FileDataStore::EXT;

        return $file;
    }
}
