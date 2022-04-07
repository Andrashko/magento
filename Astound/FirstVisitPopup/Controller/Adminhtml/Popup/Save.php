<?php

namespace Astound\FirstVisitPopup\Controller\Adminhtml\Popup;

use Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterface;
use Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterfaceFactory;
use Astound\FirstVisitPopup\Api\FirstVisitPopupRepositoryInterface;
use Magento\Backend\App\Action;

/**
 * Class Save
 *
 * @package Astound\FirstVisitPopup\Controller\Adminhtml\Popup
 */
class Save extends Action
{
    /**
     * @inheritdoc
     */
    const ADMIN_RESOURCE = 'Astound_FirstVisitPopup::popup_save';

    /** @var \Magento\Framework\App\Request\DataPersistorInterface */
    protected $dataPersistor;

    /** @var \Astound\FirstVisitPopup\Api\FirstVisitPopupRepositoryInterface */
    protected $entityRepository;

    /** @var \Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterfaceFactory */
    protected $entityFactory;

    /** @var \Magento\Framework\Api\DataObjectHelper */
    protected $dataObjectHelper;

    /**
     * Save constructor.
     *
     * @param Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param FirstVisitPopupRepositoryInterface $entityRepository
     * @param FirstVisitPopupInterfaceFactory $entityFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        FirstVisitPopupRepositoryInterface $entityRepository,
        FirstVisitPopupInterfaceFactory $entityFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->entityRepository = $entityRepository;
        $this->entityFactory = $entityFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context);
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $postData = $this->getRequest()->getPostValue();

        if (!$postData) {
            return $resultRedirect->setPath('*/*/');
        }
        $id = $this->getRequest()->getParam('id');

        try {
            if ($id === null) {
                /** @var FirstVisitPopupInterface $entity */
                $entity = $this->entityFactory->create();
            } else {
                $entity = $this->entityRepository->get($id);
            }

            $this->dataObjectHelper->populateWithArray($entity, $postData, FirstVisitPopupInterface::class);
            $this->entityRepository->save($entity);
            $this->messageManager->addSuccessMessage(__('Popup has been saved.'));
            $this->dataPersistor->clear('astound_firstvisitpopup_popup');

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $entity->getEntityId()]);
            }

            return $resultRedirect->setPath('*/*/');
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (InvalidArgumentException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Popup.'));
        }

        $this->dataPersistor->set('astound_firstvisitpopup_popup', $postData);

        return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
    }
}
