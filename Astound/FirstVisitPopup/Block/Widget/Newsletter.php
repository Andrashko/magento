<?php

namespace Astound\FirstVisitPopup\Block\Widget;

use Magento\Framework\View\Element\Template;

/**
 * Class Newsletter
 *
 * @package Astound\FirstVisitPopup\Block\Widget
 */
class Newsletter extends Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * Retrieve form action url and set "secure" param to avoid confirm
     * message when we submit form from secure page to unsecure
     *
     * @return string
     */
    public function getFormActionUrl()
    {
        return $this->getUrl('astound_firstVisitPopup/subscriber/newAction', ['_current' => true]);
    }

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getData('title');
    }
}
