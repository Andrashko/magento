<?php

namespace Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup\Relation\Store;

use Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterface;
use Astound\FirstVisitPopup\Setup\InstallSchema;
use Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

/**
 * Class ReadHandler
 *
 * @package Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup\Relation\Store
 */
class ReadHandler implements ExtensionInterface
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
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @todo: deprecated getEntityConnection
     */
    public function execute($entity, $arguments = [])
    {
        if ($entity->getId()) {
            $entityMetadata = $this->metadataPool->getMetadata(FirstVisitPopupInterface::class);
            $linkField = $entityMetadata->getLinkField();
            $select = $entityMetadata->getEntityConnection()
                ->select()
                ->from(InstallSchema::ASTOUND_FIRST_VISIT_POPUP_STORE_TABLE,
                    [
                        FirstVisitPopupInterface::STORE_ID =>
                            sprintf('GROUP_CONCAT(DISTINCT %s)', FirstVisitPopupInterface::STORE_ID)
                    ]
                )
                ->where($linkField . ' = ?', $entity->getData($linkField));

            $data = $entityMetadata->getEntityConnection()->fetchOne($select);
            $entity->setData(FirstVisitPopupInterface::STORE_ID, explode(',', $data));
        }

        return $entity;
    }
}
