<?php
namespace Uzhnu\Rest\Model\ResourceModel\Author;

use Uzhnu\Rest\Model\Author;
use Uzhnu\Rest\Model\ResourceModel\Author as AuthorResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(Author::class, AuthorResource::class);
    }
}
