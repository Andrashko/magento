<?php

namespace  Uzhnu\EventMenuUpdate\Observer;

use  Magento\Framework\Event\ObserverInterface;
use  Magento\Framework\Event\Observer;
use  Magento\Framework\View\LayoutInterface;


class TopmenuGetHtmlAfter implements  ObserverInterface
{
    protected LayoutInterface $layout;

    public  function  __construct(LayoutInterface $layout)
    {
        $this->layout = $layout;
    }

    public function execute (Observer $observer)
    {
        $transportObject = $observer->getEvent()->getData("transportObject");
        if ($transportObject)
        {
            $textLinkHtml = $this->layout
                ->createBlock("Magento\Framework\View\Element\Template")
                ->setTemplate("Uzhnu_EventMenuUpdate::html/topmenu.phtml")
                ->toHTml();
            $topMenuHtml = $transportObject->getHtml() . $textLinkHtml;
            $transportObject->setHtml($topMenuHtml);
        }
        return $this;
    }
}
