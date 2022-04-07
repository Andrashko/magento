<?php

namespace Astound\FirstVisitPopup\Model\ResourceModel;

use Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterface;
use Astound\FirstVisitPopup\Setup\InstallSchema;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\EntityManager\EntityManager;

/**
 * Class FirstVisitPopup
 *
 * @package Astound\FirstVisitPopup\Model\ResourceModel
 */
class FirstVisitPopup extends AbstractDb
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Construct
     *
     * @param Context $context
     * @param EntityManager $entityManager
     * @param null $connectionName
     */
    public function __construct(
        Context $context,
        EntityManager $entityManager,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(InstallSchema::ASTOUND_FIRST_VISIT_POPUP_TABLE, FirstVisitPopupInterface::ENTITY_ID);
    }

    /**
     * Function load
     *
     * @param AbstractModel $object
     * @param mixed $value
     * @param null $field
     * @return $this
     * @throws \LogicException
     */
    public function load(AbstractModel $object, $value, $field = null)
    {
        if ($value) {
            $this->entityManager->load($object, $value);
        }
        return $this;
    }

    /**
     * Function save
     *
     * @param AbstractModel $object
     * @return $this
     * @throws \Exception
     */
    public function save(AbstractModel $object)
    {
        $this->entityManager->save($object);
        return $this;
    }
}
