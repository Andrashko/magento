<?php

namespace Astound\FirstVisitPopup\Controller\Popup;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class View
 *
 * @package Astound\FirstVisitPopup\Controller\Popup
 */
class View extends Action
{
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \InvalidArgumentException
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
    }
}
