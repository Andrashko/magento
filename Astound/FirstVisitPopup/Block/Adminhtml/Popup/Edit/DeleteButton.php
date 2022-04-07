<?php

namespace Astound\FirstVisitPopup\Block\Adminhtml\Popup\Edit;

use Astound\FirstVisitPopup\Api\FirstVisitPopupRepositoryInterface;
use Magento\Framework\View\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class DeleteButton implements ButtonProviderInterface
{
    /** @var FirstVisitPopupRepositoryInterface  */
    protected $repository;

    /** @var Context  */
    protected $context;

    /**
     * @param Context $context
     * @param FirstVisitPopupRepositoryInterface $repository
     */
    public function __construct(
        Context $context,
        FirstVisitPopupRepositoryInterface $repository
    ) {
        $this->context = $context;
        $this->repository = $repository;
    }

    /**
     * Retrieve delete button content.
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getPopupId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\''
                    .__('Are you sure you want to do this?')
                    .'\', \''.$this->getDeleteUrl().'\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * Get delete url.
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getPopupId()]);
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
     * Return popup ID
     *
     * @return int|null
     */
    public function getPopupId()
    {
        try {
            return $this->repository->get(
                $this->context->getRequest()->getParam('id')
            )->getEntityId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }
}
