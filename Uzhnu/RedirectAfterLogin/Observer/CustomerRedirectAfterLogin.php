<?php

namespace Uzhnu\RedirecAfterLogin\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Zend\Validator\Uri as UriValidator;
use Magento\Framework\App\ResponseFactory;
use Magento\Store\Model\ScopeInterface;

class CustomerRedirectAfterLogin implements ObserverInterface
{
    protected  ScopeConfigInterface $scopeConfig;

    protected UriValidator $uri;

    protected  ResponseFactory  $responseFactory;

    public  function  __construct(
        ScopeConfigInterface $scopeConfig,
        UriValidator $uri,
        ResponseFactory  $responseFactory
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->uri = $uri;
        $this->responseFactory = $responseFactory;
    }

    public function execute(Observer $observer)
    {
        $redirectToDashboard = $this->scopeConfig->isSetFlag(
            'customer/startup/redirect_dashboard',
            ScopeInterface::SCOPE_WEBSITES
        );

        if ($redirectToDashboard)
            return;

        $redirectUri = $this->scopeConfig->getValue(
            'customer/startup/redirect_dashboard',
            ScopeInterface::SCOPE_WEBSITES
        );

        if (empty($redirectUri) || !$this->uri->isValide($redirectUri))
            return;

        $responseFactory = $this->responseFactory->create();
        $responseFactory->setRedirect($redirectUri, 200);
        exit();
    }
}
