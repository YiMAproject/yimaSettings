<?php
namespace yimaSettings\DataStore\Collection;

interface CollectionInterface
{
    /**
     * Set Identity
     * : use to separate collections row
     *
     * @return $this
     */
    public function setIdentity();

    /**
     * Get Identity
     *
     * @return string
     */
    public function getIdentity();

    /**
     * Prepare Collection
     *
     * @return $this
     */
    public function prepare();

    /**
     * Fetch Identified Data Entity
     *
     * @return DataEntity
     */
    public function fetch();

    /**
     * Save Data Entity In Collection
     * : it must use identity
     *
     * @param DataEntity $entity
     *
     * @throws \Exception Failed
     * @return $this
     */
    public function save(DataEntity $entity);

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
