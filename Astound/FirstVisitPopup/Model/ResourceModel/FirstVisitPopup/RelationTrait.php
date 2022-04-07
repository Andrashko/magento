<?php

namespace Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup;

use Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterface;
use Astound\FirstVisitPopup\Setup\InstallSchema;

/**
 * Trait RelationTrait
 *
 * @package Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup
 */
trait RelationTrait
{
    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @var array
     */
    protected $externalDataMap = [
        InstallSchema::ASTOUND_FIRST_VISIT_POPUP_STORE_TABLE => FirstVisitPopupInterface::STORE_ID
    ];

    /**
     * Join tables
     *
     * @param bool|\Magento\Framework\DB\Select $select
     * @return $this
     */
    protected function joinExternalData($select = false)
    {
        if (!$select) {
            $select = $this->getSelect();
        }
        foreach ($this->externalDataMap as $table => $column) {
            $this->joinGroupValue($select, $table, $column);
        }

        $entityMetadata = $this->metadataPool->getMetadata(FirstVisitPopupInterface::class);
        $select->group(sprintf('%s.%s', key($select->getPart('from')), $entityMetadata->getLinkField()));
        return $this;
    }

    /**
     * Join multiple values with comma delimiter
     *
     * @param \Magento\Framework\DB\Select $select
     * @param string                       $joinTable
     * @param string                       $field
     *
     * @return \Magento\Framework\DB\Select
     */
    protected function joinGroupValue(\Magento\Framework\DB\Select $select, $joinTable, $field)
    {
        $entityMetadata = $this->metadataPool->getMetadata(FirstVisitPopupInterface::class);
        return $select->joinLeft([$joinTable => $this->getTable($joinTable)],
                             sprintf('%s.%s=%s.%s',
                                     key($select->getPart('from')),
                                 $entityMetadata->getLinkField(),
                                     $joinTable,
                                 $entityMetadata->getLinkField()),
                             [
                                 $field => sprintf('GROUP_CONCAT(DISTINCT %s.%s)', $joinTable, $field)
                             ]
        );
    }

    /**
     * Explode Group Value
     *
     * @param \Magento\Framework\DataObject $item
     *
     * @return \Magento\Framework\DataObject
     */
    protected function convertGroupValue(\Magento\Framework\DataObject $item)
    {
        foreach ($this->externalDataMap as $key) {
            $item->setData($key, explode(',', $item->getData($key)));
        }
        return $item;
    }
}
