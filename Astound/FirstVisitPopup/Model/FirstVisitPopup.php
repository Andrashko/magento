<?php

namespace Astound\FirstVisitPopup\Model;

use Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterface;
use Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup as FirstVisitPopupResource;
use Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup\Collection;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class FirstVisitPopup
 *
 * @method FirstVisitPopupResource getResource()
 * @method Collection getCollection()
 * @method Collection getResourceCollection()
 *
 * @package Astound\FirstVisitPopup\Model
 */
class FirstVisitPopup extends AbstractModel implements FirstVisitPopupInterface, IdentityInterface
{
    /**
     * Cache tag
     */
    const CACHE_TAG = 'ASTOUND_FIRST_VISIT_POPUP';

    /**
     * Available statuses
     */
    const AVAILABLE_STATUSES = [self::STATUS_ENABLED, self::STATUS_DISABLED];

    /**
     * Model cache tag for clear cache in after save and after delete
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * {@inheritdoc}
     */
    protected $_eventPrefix = 'astound_first_visit_popup_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(FirstVisitPopupResource::class);
    }

    /**
     * Prepare popup's statuses
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->_getData(self::TITLE);
    }

    /**
     * @inheritdoc
     */
    public function setTitle($value)
    {
        $this->setData(self::TITLE, $value);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->_getData(self::STATUS);
    }

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function setStatus($value)
    {
        if ($value !== null && !in_array($value, self::AVAILABLE_STATUSES)) {
            throw new \InvalidArgumentException(sprintf('Provided status "%s" code is not allowed.', $value));
        }

        $this->setData(self::STATUS, $value);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        return $this->_getData(self::CONTENT);
    }

    /**
     * @inheritdoc
     */
    public function setContent($value)
    {
        $this->setData(self::CONTENT, $value);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getContentWidth()
    {
        return $this->_getData(self::CONTENT_WIDTH);
    }

    /**
     * @inheritdoc
     */
    public function setContentWidth($value)
    {
        $this->setData(self::CONTENT_WIDTH, $value);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getStoreId()
    {
        return $this->_getData(self::STORE_ID);
    }

    /**
     * @inheritdoc
     */
    public function setStoreId($value)
    {
        $this->setData(self::STORE_ID, $value);
        return $this;
    }

    /**
     * Clear cache related with popup id
     *
     * @return $this
     */
    public function cleanCache()
    {
        $this->_cacheManager->clean($this->getIdentities());
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG, sprintf('%s_%d', self::CACHE_TAG, $this->getEntityId())];
    }

    /**
     * @inheritdoc
     */
    public function getEntityId()
    {
        return (int) $this->_getData(self::ENTITY_ID);
    }
}
