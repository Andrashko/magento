<?php

namespace Uzhnu\About\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use Uzhnu\About\Model\AuthorFactory;

class Datasource extends Template
{
    protected AuthorFactory $authorFactory;

    public function __construct(Template\Context $context, AuthorFactory $authorFactory, array $data = [])
    {
        $this->authorFactory = $authorFactory;
        parent::__construct($context, $data);
    }

    public  function getAuthors()
    {
        $authors = $this->authorFactory->create();
        return $authors->getCollection();
    }

}
