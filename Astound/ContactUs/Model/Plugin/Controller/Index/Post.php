<?php

namespace Astound\ContactUs\Model\Plugin\Controller\Index;

use Astound\ContactUs\Model\Config;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Psr\Log\LoggerInterface;

/**
 * Class Post
 *
 * @package Astound\ContactUs\Model\Plugin\Controller\Index
 */
class Post
{
    /**
     * @var Config
     */
    protected $contactConfig;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * Post constructor.
     *
     * @param ManagerInterface $messageManager
     * @param DataPersistorInterface $dataPersistor
     * @param RedirectFactory $resultRedirectFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Config $contactConfig,
        ManagerInterface $messageManager,
        DataPersistorInterface $dataPersistor,
        RedirectFactory $resultRedirectFactory,
        LoggerInterface $logger
    ) {
        $this->contactConfig = $contactConfig;
        $this->messageManager = $messageManager;
        $this->dataPersistor = $dataPersistor;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->logger = $logger;
    }

    /**
     * Function aroundExecute
     *
     * @param \Magento\Contact\Controller\Index\Post $subject
     * @param \Closure $proceed
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function aroundExecute(
        \Magento\Contact\Controller\Index\Post $subject,
        \Closure $proceed
    ) {
        try {
            /** @var \Magento\Framework\HTTP\PhpEnvironment\Request $request */
            $request = $subject->getRequest();
            if (!empty($this->contactConfig->getContactSubject()) && trim($request->getPostValue('subject')) === '') {
                throw new LocalizedException(__('Subject is missing'));
            }
            $request->setPostValue('subjectText',
                $this->contactConfig->getContactSubjectById($request->getPostValue('subject'))
            );
            return $proceed();
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('contact_us', $subject->getRequest()->getParams());
            return $this->resultRedirectFactory->create()->setPath('contact/index');
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $this->messageManager->addErrorMessage(
                __('An error occurred while processing your form. Please try again later.')
            );
            $this->dataPersistor->set('contact_us', $subject->getRequest()->getParams());
            return $this->resultRedirectFactory->create()->setPath('contact/index');
        }
    }
}
