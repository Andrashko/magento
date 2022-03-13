<?php

namespace Astound\ContactUs\Block;

use Astound\ContactUs\Model\Config;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class ContactForm
 *
 * @package Astound\ContactUs\Block
 */
class ContactForm extends \Magento\Contact\Block\ContactForm
{
    /**
     * @var Config
     */
    protected $contactConfig;

    /**
     * ContactForm constructor.
     *
     * @param Context $context
     * @param Config $contactConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config $contactConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->contactConfig = $contactConfig;
    }

    /**
     * Get Available Subjects
     *
     * @return array
     */
    public function getAvailableSubjects()
    {
        $contactSubjects = trim($this->contactConfig->getContactSubject());
        if (!empty($contactSubjects)) {
            return explode("\n", $contactSubjects);
        }
        return [];
    }
}
