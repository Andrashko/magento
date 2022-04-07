<?php

namespace Astound\FirstVisitPopup\Controller\Adminhtml\Popup;

use Astound\FirstVisitPopup\Api\FirstVisitPopupRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit
 *
 * @package Astound\FirstVisitPopup\Controller\Adminhtml\Popup
 */
class Edit extends Action
{
    /** @var \Magento\Framework\View\Result\PageFactory */
    protected $resultPageFactory;

    /** @var FirstVisitPopupRepositoryInterface */
    protected $entityRepository;

    /**
     * Edit constructor.
     *
     * @param Context                    $context
     * @param PageFactory                $resultPageFactory
     * @param FirstVisitPopupRepositoryInterface $entityRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        FirstVisitPopupRepositoryInterface $entityRepository
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->entityRepository = $entityRepository;
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultPage = $this->resultPageFactory->create();
        /**
         * Set active menu item
         */
        $resultPage->setActiveMenu('Astound_FirstVisitPopup::notifications_popup');
        /**
         * Add breadcrumb item
         */
        $resultPage->addBreadcrumb(__('First Visit Popup'), __('First Visit Popup'));
        $resultPage->addBreadcrumb(__('Manage First Visit Popup'), __('Manage First Visit Popup'));

        if ($id === null) {
            $resultPage->getConfig()->getTitle()->prepend(__('New First Visit Popup'));
            return $resultPage;
        }

        try {
            $this->entityRepository->get($id);
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect = $this->resultRedirectFactory->create();

            return $resultRedirect->setPath('*/*/');
        }

        $resultPage->getConfig()->getTitle()->prepend(__('Edit First Visit Popup'));

        return $resultPage;
    }
}
