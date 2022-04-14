<?php

namespace Uzhnu\CustomerLogin\Plugin\Customer\Controller\Account;

use Magento\Customer\Model\Session;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\App\ResponseFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Customer\Controller\Account\LoginPost as MagentoLoginPost;
use Uzhnu\CustomerLogin\Model\Customer\Attribute\Source\Reason;

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

    protected Reason $reasonsList;

    public function __construct(
        Session $customerSession,
        AccountManagementInterface $customerAccountManagement,
        ResponseFactory $responseFactory,
        UrlInterface $url,
        RequestInterface $request,
        ManagerInterface $messageManager,
        Reason $reasonsList
    )
    {
        $this->session = $customerSession;
        $this->customerAccountManagement = $customerAccountManagement;
        $this->responseFactory = $responseFactory;
        $this->url = $url;
        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->reasonsList = $reasonsList;
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
                            $reasonCode = $customer->getCustomAttribute('reason');
                            $reasonValue = '';
                            if (!empty($reasonCode)) {
                                $reasonValue = $reasonCode->getValue();
                            }
                            $this->messageManager->addError(
                                __('Your account is blocked for the following reason: %1', $this->reasonsList->getMessage($reasonValue))
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
