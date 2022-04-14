<?php

namespace Uzhnu\CustomerLogin\Model\Customer\Attribute\Source;

use Magento\Customer\Model\Customer\Attribute\Source\GroupSourceLoggedInOnlyInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Table;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\ScopeInterface;

class Reason extends Table
    implements GroupSourceLoggedInOnlyInterface
{
    const XML_REASONS_LIST = 'customer/login_status/reasons';

    protected ScopeConfigInterface $scopeConfig;

    protected Json $serialize;

    public function __construct(
        CollectionFactory $attrOptionCollectionFactory,
        OptionFactory $attrOptionFactory,
        ScopeConfigInterface $scopeConfig,
        Json $serialize
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->serialize = $serialize;
        parent::__construct($attrOptionCollectionFactory, $attrOptionFactory);
    }


    public function getAllOptions($withEmpty = true, $defaultValues = false)
    {
        if (!$this->_options) {
            $this->_options = $this->getReasonsList();
        }

        return $this->_options;
    }


    private function getReasonsList()
    {
        $options = [];
        $options[] = [
            'value' => '0',
            'label' => __('-- Please select a reason --'),
        ];

        $reasonsList = $this->scopeConfig->getValue(self::XML_REASONS_LIST, ScopeInterface::SCOPE_STORE);

        if (!empty($reasonsList)) {
            $_reasonsList = $this->serialize->unserialize($reasonsList);
            foreach ($_reasonsList as $reason) {
                $options[] = [
                    'value' => $reason['id'],
                    'label' => $reason['reason'],
                ];
            }
        }

        return $options;
    }


    public function getMessage($value)
    {
        $reasonsList = $this->getReasonsList();
        foreach ($reasonsList as $reason) {
            if ($value == $reason['value'] && $value != '0') {
                return $reason['label'];
            }
        }
        return __('Please contact us for details.');
    }
}
