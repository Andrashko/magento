<?php

namespace Astound\FirstVisitPopup\Model;

use Astound\BaseEntity\Model\BaseRepositoryTrait;
use Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterfaceFactory;
use Astound\FirstVisitPopup\Api\Data\FirstVisitPopupSearchResultInterfaceFactory;
use Astound\FirstVisitPopup\Api\FirstVisitPopupRepositoryInterface;
use Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup as FirstVisitPopupResource;
use Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup\CollectionFactory;


/**
 * Class FirstVisitPopupRepository
 *
 * @package \Astound\FirstVisitPopup\Model
 */
class FirstVisitPopupRepository implements FirstVisitPopupRepositoryInterface
{
    use BaseRepositoryTrait;

    /** @var CollectionFactory */
    protected $collectionFactory;

    /** @var FirstVisitPopupInterfaceFactory */
    protected $factory;

    /** @var FirstVisitPopupResource */
    protected $resource;

    /** @var FirstVisitPopupSearchResultInterfaceFactory */
    protected $searchResultFactory;

    /**
     * FirstVisitPopupRepository constructor.
     *
     * @param FirstVisitPopupResource $resource
     * @param FirstVisitPopupInterfaceFactory $factory
     * @param CollectionFactory $collectionFactory
     * @param FirstVisitPopupSearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(
        FirstVisitPopupResource $resource,
        FirstVisitPopupInterfaceFactory $factory,
        CollectionFactory $collectionFactory,
        FirstVisitPopupSearchResultInterfaceFactory $searchResultFactory
    )
    {
        $this->resource = $resource;
        $this->factory = $factory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $searchResultFactory;
    }
}
