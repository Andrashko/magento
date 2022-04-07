<?php

namespace Astound\FirstVisitPopup\Controller\Adminhtml\Popup;

use Astound\FirstVisitPopup\Api\FirstVisitPopupRepositoryInterface;
use Magento\Backend\App\Action;

/**
 * Class Duplicate
 *
 * @package Astound\FirstVisitPopup\Controller\Adminhtml\Popup
 */
class Duplicate extends Action
{
    /**
     * @inheritdoc
     */
    const ADMIN_RESOURCE = 'Astound_FirstVisitPopup::popup_save';

    /** @var \Magento\Framework\App\Request\DataPersistorInterface */
    protected $dataPersistor;

    /** @var \Astound\FirstVisitPopup\Api\FirstVisitPopupRepositoryInterface */
    protected $entityRepository;

    /**
     * Save constructor.
     *
     * @param Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param FirstVisitPopupRepositoryInterface $entityRepository
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        FirstVisitPopupRepositoryInterface $entityRepository
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->entityRepository = $entityRepository;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id === null) {
            $this->messageManager->addErrorMessage(__('We can\'t find a popup to duplicate .'));
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $entity = $this->entityRepository->get($id);
            $entity->unsetData('entity_id');
            $this->entityRepository->save($entity);

            $this->messageManager->addSuccessMessage(__('Popup has been duplicated.'));
            $this->dataPersistor->clear('astound_firstvisitpopup_popup');
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\InvalidArgumentException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Popup.'));
        }

        $this->dataPersistor->set('astound_firstvisitpopup_popup', $entity->getData());
        return $resultRedirect->setPath('*/*/');
    }
}
