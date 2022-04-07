<?php

namespace Astound\FirstVisitPopup\Block;

use Astound\FirstVisitPopup\Model\Service\PopupService;
use Astound\FirstVisitPopup\Model\FirstVisitPopup\Config;
use Astound\FirstVisitPopup\Model\FirstVisitPopup;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Serialize\SerializerInterface;

class Popup extends Template implements \Magento\Framework\DataObject\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    const COOKIE_NAME = 'astound_first_visit_popup';

    /** @var SerializerInterface */
    protected $serializer;

    /**
     * PopupService
     *
     * @var PopupService
     */
    protected $popupService;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $filterProvider;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Popup constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param PopupService $popupService
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Config $config
     * @param SerializerInterface $serializer
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        PopupService $popupService,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Config $config,
        SerializerInterface $serializer,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->popupService = $popupService;
        $this->filterProvider = $filterProvider;
        $this->storeManager = $storeManager;
        $this->config = $config;
        $this->serializer = $serializer;
        $this->jsLayout = $this->initJsLayout($data);
    }

    /**
     * Function getJsLayout
     *
     * @return bool|string
     */
    public function getJsLayout()
    {
        $result = '';

        try {
            $result = $this->serializer->serialize($this->jsLayout);
        } catch (\Exception $e) {
            $this->_logger->critical($e->getMessage());
        }

        return $result;
    }

    /**
     * Function initJsLayout
     *
     * @param array $data
     * @return array
     */
    protected function initJsLayout(array $data): array
    {
        if (!$this->isEntityExist()) {
            return $data;
        }

        if (isset($data['jsLayout']) && is_array($data['jsLayout'])) {
            return $data['jsLayout'];
        }

        $defaultLayout = [
            'components' => [
                'first-visit-popup' => [
                    'component'   => 'Astound_FirstVisitPopup/js/popup',
                    'cookieName' => $this->getCookieName(),
                    'cookieLifetime' => $this->getCookieLifetime(),
                    'content_width' => $this->getContentWidth()
                ]
            ]
        ];

        return $defaultLayout;
    }

    /**
     * Get Content Width
     *
     * @return int
     */
    public function getContentWidth(): int
    {
        if ($this->isEntityExist()) {
            return $this->popupService->getPopupEntity()->getContentWidth();
        }
        return 0;
    }

    /**
     * Get Cookie Name
     *
     * @return string
     */
    public function getCookieName()
    {
        return self::COOKIE_NAME;
    }

    /**
     * Get Cookie Lifetime
     *
     * @return float
     */
    public function getCookieLifetime(): float
    {
        return (float) $this->config->getCloseCookieLifetime();
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities(): array
    {
        return [FirstVisitPopup::CACHE_TAG];
    }

    /**
     * Get tags array for saving cache
     *
     * @return array
     */
    protected function getCacheTags(): array
    {
        return array_merge(parent::getCacheTags(), $this->getIdentities());
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getEntityContent(): string
    {
        $html = '';
        if ($this->isEntityExist()) {
            $storeId = $this->storeManager->getStore()->getId();
            $html = $this->filterProvider->getBlockFilter()
                ->setStoreId($storeId)->filter($this->popupService->getPopupEntity()->getContent());
        }
        return $html;
    }

    /**
     * Function isEntityExist
     *
     * @return bool
     */
    protected function isEntityExist()
    {
        return $this->popupService->getPopupEntity() && $this->popupService->getPopupEntity()->getId();
    }
}
