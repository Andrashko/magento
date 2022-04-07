<?php

namespace Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup;

use Astound\FirstVisitPopup\Model\FirstVisitPopup;
use Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup as FirstVisitPopupResource;
use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\EntityManager\MetadataPool;

/**
 * Class FirstVisitPopup
 *
 * @method FirstVisitPopupResource getResource()
 * @method FirstVisitPopup[] getItems()
 * @method FirstVisitPopup[] getItemsByColumnValue($column, $value)
 * @method FirstVisitPopup getFirstItem()
 * @method FirstVisitPopup getLastItem()
 * @method FirstVisitPopup getItemByColumnValue($column, $value)
 * @method FirstVisitPopup getItemById($idValue)
 * @method FirstVisitPopup getNewEmptyItem()
 * @method FirstVisitPopup fetchItem()
 * @property FirstVisitPopup[] _items
 * @property FirstVisitPopupResource _resource
 */
class Collection extends AbstractCollection
{
    use RelationTrait;

    /**
     * Collection constructor.
     *
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        MetadataPool $metadataPool,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->metadataPool = $metadataPool;
    }

    /** @var string */
    protected $_idFieldName = 'entity_id';

    /**
     * @inheritdoc
     */
    protected $_eventPrefix = 'astound_first_visit_popup_collection';

    /**
     * @inheritdoc
     */
    protected $_eventObject = 'collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(FirstVisitPopup::class, FirstVisitPopupResource::class);
    }

    /**
     * Join Relation Tables
     *
     * @return $this
     */
    protected function _renderFiltersBefore()
    {
        $this->joinExternalData();
        return $this;
    }

    /**
     * Prepare Group Value
     *
     * @param DataObject $item
     *
     * @return DataObject
     */
    protected function beforeAddLoadedItem(DataObject $item)
    {
        $this->convertGroupValue($item);
        return parent::beforeAddLoadedItem($item);
    }
}
