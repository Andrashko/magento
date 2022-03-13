<?php

namespace Uzhnu\About\Controller\Index;

use \Magento\Framework\App\ActionInterface;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\View\Result\Page;

class Index implements ActionInterface
{

    protected PageFactory $pageFactory;

    public function __construct(
        PageFactory $resultPageFactory
    ) {
        $this->pageFactory = $resultPageFactory;
    }

    public function execute(): Page
    {
        return $this->pageFactory->create();
    }
}
