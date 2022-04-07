<?php

namespace Astound\FirstVisitPopup\Model\FirstVisitPopup;

use Astound\FirstVisitPopup\Api\FirstVisitPopupRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;

/**
 * Class DataProvider
 *
 * @package Astound\FirstVisitPopup\Model\FirstVisitPopup
 */
class DataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    /** @var array */
    protected $loadedData = [];

    /** @var FirstVisitPopupRepositoryInterface */
    protected $repository;

    /**
     * DataProvider constructor.
     *
     * @param string                     $name
     * @param string                     $primaryFieldName
     * @param string                     $requestFieldName
     * @param ReportingInterface         $reporting
     * @param SearchCriteriaBuilder      $searchCriteriaBuilder
     * @param RequestInterface           $request
     * @param FilterBuilder              $filterBuilder
     * @param FirstVisitPopupRepositoryInterface $repository
     * @param array                      $meta
     * @param array                      $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        FirstVisitPopupRepositoryInterface $repository,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        if ($this->loadedData) {
            return $this->loadedData;
        }
        $firstVisitPopup = $this->repository->find($this->request->getParam($this->getRequestFieldName()));
        if ($firstVisitPopup) {
            $data = $firstVisitPopup->getData();
            $data[$this->getRequestFieldName()] = $firstVisitPopup->getId();
            $data[$this->getPrimaryFieldName()] = $firstVisitPopup->getId();
            $this->loadedData = [$firstVisitPopup->getId() => $data];
        }

        return $this->loadedData;
    }
}
