<?php
namespace yimaSettings\DataStore\Collection;

use yimaSettings\DataStore\Entity;

interface CollectionInterface
{
    /**
     * Set Identity
     * : use to separate collections row
     *
     * @param string $identity Identity
     *
     * @return $this
     */
    public function setIdentity($identity);

    /**
     * Get Identity
     *
     * @return string
     */
    public function getIdentity();

    /**
     * Prepare Collection
     * : before any transaction with storage device
     *   fetch, save, destroy
     *
     * @return $this
     */
    public function prepare();

    /**
     * Fetch Identified Data Entity
     *
     * @return Entity
     */
    public function fetch();

    /**
     * Save Data Entity In Collection
     * : it must use identity
     *
     * @param Entity $entity
     *
     * @throws \Exception Failed
     * @return $this
     */
    public function save(Entity $entity);

    /**
     * Destroy Identity Collection And All Data
     *
     * @throws \Exception Failed
     * @return $this
     */
    public function destroy();

    // -------------------------------------------------------------------------

    /**
     * Set Option
     *
     * @param string $option Option
     * @param mixed  $value  Value
     *
     * @return $this
     */
    public function setOption($option, $value);

    /**
     * Get Option Value
     *
     * @param string $option Option Name
     *
     * @return mixed|null
     */
    public function getOption($option);

    /**
     * Set Options
     *
     * @param array $options Associated Options
     *
     * @return $this
     */
    public function setOptions(array $options);
}
