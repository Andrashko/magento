<?php

namespace Astound\FirstVisitPopup\Controller\Subscriber;

/**
 * Class NewAction
 *
 * @package Astound\FirstVisitPopup\Controller\Subscriber
 */
class NewAction extends \Magento\Newsletter\Controller\Subscriber\NewAction
{
    /**
     * New subscription action
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return string
     */
    public function execute()
    {
        $response = new \Magento\Framework\DataObject();
        $response->setError(false);
        $messages = [];
        if ($this->getRequest()->getParam('email')) {
            $email = (string)$this->getRequest()->getParam('email');

            try {
                $this->validateEmailFormat($email);
                $this->validateGuestSubscription();
                $this->validateEmailAvailable($email);

                $subscriber = $this->_subscriberFactory->create()->loadByEmail($email);
                if ($subscriber->getId()
                    && $subscriber->getSubscriberStatus() == \Magento\Newsletter\Model\Subscriber::STATUS_SUBSCRIBED
                ) {
                    $response->setError(true);
                    $messages[] = __('This email address is already subscribed.');
                }
                $status = $this->_subscriberFactory->create()->subscribe($email);
                if ($status == \Magento\Newsletter\Model\Subscriber::STATUS_NOT_ACTIVE) {
                    $messages[] = __('The confirmation request has been sent.');
                } else {
                    $messages[] = __('Thank you for your subscription.');
                }
                $response->setHtmlMessage(implode(' ', $messages));
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $response->setError(true);
                $response->setHtmlMessage(__('There was a problem with the subscription: %1', $e->getMessage()));
            } catch (\Exception $e) {
                $response->setError(true);
                $response->setHtmlMessage(__('Something went wrong with the subscription.'));
            }
        } else {
            $response->setError(true);
            $response->setHtmlMessage(__('Email address is not specified.'));
        }
        $this->getResponse()->representJson($response->toJson());
    }
}
