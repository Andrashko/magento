<?php

namespace Astound\FirstVisitPopup\Controller\Adminhtml\Popup;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Astound\FirstVisitPopup\Model\ResourceModel\FirstVisitPopup\CollectionFactory;
use Astound\FirstVisitPopup\Api\FirstVisitPopupRepositoryInterface;

/**
 * Class MassDelete
 *
 * @package Astound\FirstVisitPopup\Controller\Adminhtml\Popup
 */
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var string
     */
    protected $redirectUrl = '*/*/';

    /** @var Filter */
    protected $filter;

    /** @var CollectionFactory */
    protected $collectionFactory;

    /** @var FirstVisitPopupRepositoryInterface */
    protected $entityRepository;

    /**
     * MassDelete constructor.
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param FirstVisitPopupRepositoryInterface $entityRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        FirstVisitPopupRepositoryInterface $entityRepository
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->entityRepository = $entityRepository;
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return $this|\Magento\Backend\Model\View\Result\Redirect
     * @throws \InvalidArgumentException
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            return $this->massAction($collection);
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath($this->redirectUrl);
        }
    }

    /**
     * Mass action
     *
     * @param AbstractCollection $collection
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \InvalidArgumentException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    protected function massAction(AbstractCollection $collection)
    {
        $popupsDeleted = 0;
        foreach ($collection->getAllIds() as $popupId) {
            $this->entityRepository->deleteById($popupId);
            $popupsDeleted++;
        }

        if ($popupsDeleted) {
            $this->messageManager->addSuccess(__('A total of %1 record(s) were deleted.', $popupsDeleted));
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
