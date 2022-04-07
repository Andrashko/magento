<?php

namespace Astound\FirstVisitPopup\Model\Service;

use Astound\FirstVisitPopup\Api\FirstVisitPopupRepositoryInterface;
use Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

class PopupService
{
    /**
     * @var FirstVisitPopupRepositoryInterface
     */
    protected $entityRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var \Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterface
     */
    protected $entity;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Popup constructor
     *
     * @param \Magento\Framework\View\Element\Context $context
     * @param FirstVisitPopupRepositoryInterface $entityRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param StoreManagerInterface $storeManager
     * @internal param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        FirstVisitPopupRepositoryInterface $entityRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        StoreManagerInterface $storeManager
    ) {
        $this->entityRepository = $entityRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->storeManager = $storeManager;
    }

    /**
     * Get Popup Entity
     *
     * @return FirstVisitPopupInterface|null
     */
    public function getPopupEntity()
    {
        if (null === $this->entity) {
            $this->searchCriteriaBuilder->addFilter(FirstVisitPopupInterface::STATUS,
                FirstVisitPopupInterface::STATUS_ENABLED);
            $this->searchCriteriaBuilder->addFilter(FirstVisitPopupInterface::STORE_ID,
                [Store::DEFAULT_STORE_ID, (int)$this->storeManager->getStore()->getId()], 'in');

            $sortOrder = $this->sortOrderBuilder->setField(FirstVisitPopupInterface::UPDATED_AT)
                ->setDirection('DESC')->create();
            $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);
            $this->searchCriteriaBuilder->setPageSize(1);
            $popupItems =  $this->entityRepository->getList($this->searchCriteriaBuilder->create())->getItems();

            foreach ($popupItems as $popup) {
                $this->entity = $popup;
            }
        }
        return $this->entity;
    }
}
