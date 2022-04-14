<?php

namespace Uzhnu\CustomerLogin\Plugin\Customer\Controller\Account;

use Magento\Customer\Model\Session;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\App\ResponseFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Customer\Controller\Account\LoginPost as MagentoLoginPost;

class LoginPost
{
    /**
     * @var \Magento\Customer\Api\AccountManagementInterface
     */
    protected $customerAccountManagement;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var \Magento\Framework\App\ResponseFactory
     */
    protected $responseFactory;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    public function __construct(
        Session $customerSession,
        AccountManagementInterface $customerAccountManagement,
        ResponseFactory $responseFactory,
        UrlInterface $url,
        RequestInterface $request,
        ManagerInterface $messageManager
    )
    {
        $this->session = $customerSession;
        $this->customerAccountManagement = $customerAccountManagement;
        $this->responseFactory = $responseFactory;
        $this->url = $url;
        $this->request = $request;
        $this->messageManager = $messageManager;
    }

    public function beforeExecute(
        MagentoLoginPost $subject
    )
    {
        if ($this->request->isPost() && !$this->session->isLoggedIn()) {
            $login = $this->request->getPost('login');
            if (!empty($login['username']) && !empty($login['password'])) {
                try {
                    $customer = $this->customerAccountManagement->authenticate($login['username'], $login['password']);
                    if ($customer->getId()) {
                        $loginStatus = $customer->getCustomAttribute('login_status');
                        // If the customer is blocked, 1 is locked, 0 is unlocked
                        if ($loginStatus && $loginStatus->getValue() == '1') {
                            // Display the reason
                            // You can create a customization message here
                            $this->messageManager->addError(
                                __('Your account is blocked for the security reason, please contact us for details.')
                            );
                            $resultRedirect = $this->responseFactory->create();
                            // Redirect to the customer login page
                            $resultRedirect->setRedirect($this->url->getUrl('customer/account/login'))->sendResponse('200');
                            exit();
                        }
                    }
                } catch (Exception $e) {
                    $this->messageManager->addErrorMessage(
                        __('An unspecified error occurred. Please contact us for assistance.')
                    );
                }
            }
        }
    }
}
