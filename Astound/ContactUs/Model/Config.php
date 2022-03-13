<?php

namespace Astound\ContactUs\Model;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Config
 *
 * @package Astound\ContactUs\Model
 */
class Config
{
    /**#@+
     * Xml paths
     */
    const CONTACT_CONTACT_SUBJECT = 'contact/contact/subject';
    /**#@-*/

    /** @var \Magento\Framework\App\Config\ScopeConfigInterface */
    protected $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get contact subject
     *
     * @return string
     */
    public function getContactSubject()
    {
        return $this->scopeConfig->getValue(self::CONTACT_CONTACT_SUBJECT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get contact subject by Id
     *
     * @return string
     */
    public function getContactSubjectById($id)
    {
        $contactSubjectArray = explode("\n", $this->getContactSubject());
        return $contactSubjectArray[$id - 1] ?? '';
    }
}
