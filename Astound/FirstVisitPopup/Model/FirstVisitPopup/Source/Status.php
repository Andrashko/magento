<?php

namespace Astound\FirstVisitPopup\Model\FirstVisitPopup\Source;

use Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 *
 * @package Astound\FirstVisitPopup\Model\FirstVisitPopup\Source
 */
class Status implements OptionSourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => __('Enabled'),
                'value' => FirstVisitPopupInterface::STATUS_ENABLED,
            ],
            [
                'label' => __('Disabled'),
                'value' => FirstVisitPopupInterface::STATUS_DISABLED,
            ]
        ];
    }
}
