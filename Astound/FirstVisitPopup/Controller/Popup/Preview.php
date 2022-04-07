<?php

namespace Astound\FirstVisitPopup\Controller\Popup;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Preview extends Action
{
    /**
     * Execute
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \InvalidArgumentException
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
    }
}
