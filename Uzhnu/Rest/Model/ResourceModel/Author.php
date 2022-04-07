<?php
namespace Uzhnu\Rest\Model\ResourceModel;

use Uzhnu\Rest\Api\Data\AuthorInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;


class Author extends AbstractDb
{

    const TABLE_NAME = 'uzhnu_rest_author';

    protected function _construct() //@codingStandardsIgnoreLine
    {
        $this->_init('uzhnu_rest_author', 'author_id');
    }
}
