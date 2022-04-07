<?php

namespace Astound\FirstVisitPopup\Model\FirstVisitPopup;

use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 *
 * @package Astound\FirstVisitPopup\Model\FirstVisitPopup
 */
class Config
{
    /**#@+
     * Xml paths
     */
    const CLOSE_COOKIE_LIFETIME = 'first_visit_popup/general/close_cookie_lifetime';
    /**#@-*/

    /** @var \Magento\Framework\App\Config\ScopeConfigInterface */
    protected $scopeConfig;

    /**
     * Config constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Close cookie lifetime (days)
     *
     * @param \Magento\Framework\App\ScopeInterface|string $store
     *
     * @return bool
     */
    public function getCloseCookieLifetime($store = null)
    {
        return $this->scopeConfig->getValue(self::CLOSE_COOKIE_LIFETIME, ScopeInterface::SCOPE_STORE, $store);
    }
}
