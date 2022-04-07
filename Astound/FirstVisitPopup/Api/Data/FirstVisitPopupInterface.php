<?php

namespace Astound\FirstVisitPopup\Api\Data;

use Astound\BaseEntity\Api\Data\BaseDataInterface;

/**
 * Interface FirstVisitPopupInterface
 *
 * @package Astound\FirstVisitPopup\Api\Data
 */
interface FirstVisitPopupInterface extends BaseDataInterface
{
    /**#@+
     * Constants for keys of data array.
     */
    const TITLE                = 'title';
    const CONTENT              = 'content';
    const CONTENT_WIDTH        = 'content_width';
    const STORE_ID             = 'store_id';
    const STATUS               = 'status';
    const UPDATED_AT           = 'updated_at';
    /**#@-*/

    /**#@+
     * Available statuses
     */
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED  = 1;
    /**#@-*/

    /**
     * Get entity ID
     *
     * @return string
     */
    public function getEntityId();

    /**
     * Get title value.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set title value.
     *
     * @param string $value
     * @return $this
     */
    public function setTitle($value);

    /**
     * Get Content value.
     *
     * @return string
     */
    public function getContent();

    /**
     * Set Content value.
     *
     * @param string $value
     * @return $this
     */
    public function setContent($value);

    /**
     * Get Content width
     *
     * @return string
     */
    public function getContentWidth();

    /**
     * Set Content width
     *
     * @param string $value
     * @return $this
     */
    public function setContentWidth($value);

    /**
     * Get isEnabled value
     *
     * @return int
     */
    public function getStatus();

    /**
     * Set isEnabled value
     *
     * @param int $value
     * @return $this
     */
    public function setStatus($value);

    /**
     * Get Store Ids
     *
     * @return int[]
     */
    public function getStoreId();

    /**
     * Set Store Ids
     *
     * @param null|int[] $value
     * @return $this
     */
    public function setStoreId($value);
}
