<?php

namespace Uzhnu\ListPages\Block;

use Magento\Framework\View\Element\Template;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template\Context;

class PageList extends Template
{

    protected PageRepositoryInterface $pageRepository;
    protected SearchCriteriaBuilder $searchCriteriaBuilder;
    protected UrlInterface $url;

    public function __construct(
        Context $context,
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        UrlInterface $url,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->url = $url;
    }

    public function  getListJson()
    {
        $list = [];
        foreach ($this->getPages() as $page)
        {
            $list[$page->getIdentifier()] = [
                "title" => $page->getTitle(),
                "url" => $this->url->getUrl($page->getIdentifier())
            ];
        }
        return json_encode($list);
    }

    private function getPages()
    {
        $searchCriteria =  $this->searchCriteriaBuilder->create();
        $pages = $this->pageRepository->getList($searchCriteria);
        return $pages->getItems();
    }
}
