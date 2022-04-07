<?php

namespace Astound\FirstVisitPopup\Api;

use Astound\BaseEntity\Api\BaseRepositoryInterface;
use Astound\FirstVisitPopup\Api\Data\FirstVisitPopupInterface;
use Astound\FirstVisitPopup\Api\Data\FirstVisitPopupSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Store\Model\Store;

/**
 * Interface FirstVisitPopupRepositoryInterface
 *
 * @method FirstVisitPopupInterface find($id, $storeId = Store::DEFAULT_STORE_ID)
 * @method FirstVisitPopupInterface get($id, $storeId = Store::DEFAULT_STORE_ID)
 * @method FirstVisitPopupSearchResultInterface getList(SearchCriteriaInterface $searchCriteria, $storeId = Store::DEFAULT_STORE_ID)
 *
 * @package \Astound\FirstVisitPopup\Api
 */
interface FirstVisitPopupRepositoryInterface extends BaseRepositoryInterface
{
}
