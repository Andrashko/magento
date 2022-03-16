<?php

namespace  Uzhnu\About\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Author extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('uzhnu_about_author', 'id');
    }
}
