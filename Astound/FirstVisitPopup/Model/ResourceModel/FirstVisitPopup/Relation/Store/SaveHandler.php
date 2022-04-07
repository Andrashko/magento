<?php

namespace Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup\Relation\Store;

use Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterface;
use Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup;
use Astound\FirstVisitPopup\Setup\InstallSchema;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Store\Model\Store;

/**
 * Class SaveHandler
 *
 * @package Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup\Relation\Store
 */
class SaveHandler implements ExtensionInterface
{
    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @var FirstVisitPopup
     */
    protected $resourcePopup;

    /**
     * Construct
     *
     * @param MetadataPool $metadataPool
     * @param FirstVisitPopup $resourcePopup
     */
    public function __construct(
        MetadataPool $metadataPool,
        FirstVisitPopup $resourcePopup
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourcePopup = $resourcePopup;
    }

    /**
     * Execute
     *
     * @param object $entity
     * @param array $arguments
     * @return object
     * @throws \Exception
     */
    public function execute($entity, $arguments = [])
    {
        $this->removeRelations($entity,InstallSchema::ASTOUND_FIRST_VISIT_POPUP_STORE_TABLE);
        $storeIds = $entity->getStoreId() ?? [Store::DEFAULT_STORE_ID];
        $entityMetadata = $this->metadataPool->getMetadata(FirstVisitPopupInterface::class);
        $linkField = $entityMetadata->getLinkField();
        $relations = array_map(function ($store) use ($entity, $linkField) {
            return [
                $linkField => $entity->getData($linkField),
                FirstVisitPopupInterface::STORE_ID  => $store
            ];
        }, array_unique($storeIds));

        $entityMetadata->getEntityConnection()
            ->insertMultiple(InstallSchema::ASTOUND_FIRST_VISIT_POPUP_STORE_TABLE, $relations);
        return $entity;
    }

    /**
     * Remove relations
     *
     * @param $entity
     * @param $table
     * @throws \Exception
     */
    protected function removeRelations($entity, $table)
    {
        $entityMetadata = $this->metadataPool->getMetadata(FirstVisitPopupInterface::class);
        $entityMetadata->getEntityConnection()->delete($table,
            [sprintf('%s = ?', $entityMetadata->getLinkField()) => $entity->getData($entityMetadata->getLinkField())]
        );
    }
}
