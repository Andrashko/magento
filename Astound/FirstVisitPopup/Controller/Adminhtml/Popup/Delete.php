<?php

namespace Astound\FirstVisitPopup\Controller\Adminhtml\Popup;

use Astound\FirstVisitPopup\Api\FirstVisitPopupRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

/**
 * Class Delete
 *
 * @package Astound\FirstVisitPopup\Controller\Adminhtml\Popup
 */
class Delete extends Action
{
    /**
     * @inheritdoc
     */
    const ADMIN_RESOURCE = 'Astound_FirstVisitPopup::popup_delete';

    /** @var FirstVisitPopupRepositoryInterface */
    protected $entityRepository;

    /**
     * Delete constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param FirstVisitPopupRepositoryInterface          $entityRepository
     */
    public function __construct(
        Context $context,
        FirstVisitPopupRepositoryInterface $entityRepository
    ) {
        $this->entityRepository = $entityRepository;
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id === null) {
            $this->messageManager->addErrorMessage(__('We can\'t find a popup to delete .'));
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $this->entityRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('Popup has been deleted.'));
            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
    }
}
