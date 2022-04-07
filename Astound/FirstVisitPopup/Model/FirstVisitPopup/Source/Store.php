<?php

namespace Astound\FirstVisitPopup\Model\FirstVisitPopup\Source;

use Magento\Store\Ui\Component\Listing\Column\Store\Options as StoreOptions;

/**
 * Class Store
 *
 * @package Astound\FirstVisitPopup\Model\FirstVisitPopup\Source
 */
class Store extends StoreOptions
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $this->currentOptions['All Store Views']['label'] = __('All Store Views');
        $this->currentOptions['All Store Views']['value'] = \Magento\Store\Model\Store::DEFAULT_STORE_ID;

        $this->generateCurrentOptions();

        $this->options = array_values($this->currentOptions);

        return $this->options;
    }
}
