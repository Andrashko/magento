<?php

namespace  Uzhnu\About\Model\ResourceModel\Author;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Uzhnu\About\Model\Author', 'Uzhnu\About\Model\ResourceModel\Author');
    }
}
