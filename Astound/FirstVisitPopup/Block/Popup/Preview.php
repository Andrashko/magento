<?php

namespace Astound\FirstVisitPopup\Block\Popup;

use Astound\FirstVisitPopup\Api\FirstVisitPopupRepositoryInterface;
use Astound\FirstVisitPopup\Model\Service\PopupService;
use Astound\FirstVisitPopup\Model\FirstVisitPopup;
use Magento\Framework\View\Element\Template;

class Preview extends Template implements \Magento\Framework\DataObject\IdentityInterface
{
    /**
     * @var \Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterface
     */
    protected $entityRepository;

    /**
     * @var PopupService
     */
    protected $currentEntity;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $filterProvider;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Popup constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param FirstVisitPopupRepositoryInterface $entityRepository
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        FirstVisitPopupRepositoryInterface $entityRepository,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->entityRepository = $entityRepository;
        $this->filterProvider = $filterProvider;
        $this->storeManager = $storeManager;
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [FirstVisitPopup::CACHE_TAG];
    }

    /**
     * Get tags array for saving cache
     *
     * @return array
     */
    protected function getCacheTags()
    {
        return array_merge(parent::getCacheTags(), $this->getIdentities());
    }

    /**
     * Function getEntityContent
     *
     * @return string
     */
    public function getEntityContent()
    {
        $html = '';
        if ($this->getCurrentPopup() && $this->getCurrentPopup()->getId()) {
            $storeId = $this->storeManager->getStore()->getId();
            $html = $this->filterProvider->getBlockFilter()
                ->setStoreId($storeId)->filter($this->getCurrentPopup()->getContent());
        }
        return $html;
    }

    /**
     * Get Current Popup
     *
     * @return \Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterface|PopupService
     */
    protected function getCurrentPopup()
    {
        if (null === $this->currentEntity) {
            $id = $this->getRequest()->getParam('id');
            $this->currentEntity = $this->entityRepository->find($id);
        }
        return $this->currentEntity;
    }
}
