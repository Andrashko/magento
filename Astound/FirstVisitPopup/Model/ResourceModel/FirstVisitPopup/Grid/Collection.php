<?php

namespace Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup\Grid;

use Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup\RelationTrait;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;
use Magento\Framework\EntityManager\MetadataPool;

/**
 * Class Collection
 *
 * @package Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup\Grid
 */
class Collection extends SearchResult
{
    use RelationTrait;

    /**
     * Collection constructor.
     *
     * @param EntityFactory $entityFactory
     * @param Logger $logger
     * @param FetchStrategy $fetchStrategy
     * @param EventManager $eventManager
     * @param MetadataPool $metadataPool
     * @param null|string $mainTable
     * @param null $resourceModel
     * @param null $identifierName
     * @param null $connectionName
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        MetadataPool $metadataPool,
        $mainTable,
        $resourceModel = null,
        $identifierName = null,
        $connectionName = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel, $identifierName, $connectionName);
        $this->metadataPool = $metadataPool;
    }

    /**
     * @inheritdoc
     */
    protected $_eventPrefix = 'astound_first_visit_popup_grid_collection';

    /**
     * @inheritdoc
     */
    protected $_eventObject = 'collection';

    /**
     * Initialization here
     *
     * @return void
     */
    protected function _construct()
    {
        $this->addFilterToMap('entity_id', 'main_table.entity_id');
        parent::_construct();
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
     * Explode Group Value
     *
     * @param DataObject $item
     *
     * @return DataObject
     */
    protected function beforeAddLoadedItem(DataObject $item): \Magento\Framework\DataObject
    {
        $this->convertGroupValue($item);
        return parent::beforeAddLoadedItem($item);
    }
}
