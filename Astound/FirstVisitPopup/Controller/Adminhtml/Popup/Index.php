<?php

namespace Astound\FirstVisitPopup\Controller\Adminhtml\Popup;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 *
 * @package Astound\MegaMenu\Controller\Adminhtml\Menu
 */
class Index extends \Magento\Backend\App\Action
{
    /** @var \Magento\Framework\View\Result\PageFactory */
    protected $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();

        /**
         * Set active menu item
         */
        $resultPage->setActiveMenu('Astound_FirstVisitPopup::notifications_popup');
        $resultPage->getConfig()->getTitle()->prepend(__('First Visit Popup'));

        /**
         * Add breadcrumb item
         */
        $resultPage->addBreadcrumb(__('First Visit Popup'), __('First Visit Popup'));
        $resultPage->addBreadcrumb(__('Manage First Visit Popup'), __('Manage First Visit Popup'));

        return $resultPage;
    }
}
