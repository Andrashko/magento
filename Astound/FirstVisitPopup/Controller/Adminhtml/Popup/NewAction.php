<?php

namespace Astound\FirstVisitPopup\Controller\Adminhtml\Popup;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;

/**
 * Class NewAction
 *
 * @package Astound\FirstVisitPopup\Controller\Adminhtml\Popup
 */
class NewAction extends Action
{
    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function execute()
    {
        /** @var Forward $resultForward */
        $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $resultForward->forward('edit');
    }
}
