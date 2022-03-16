<?php

namespace  Uzhnu\About\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;
use Uzhnu\About\Api\Data\AuthorInterface;

class Author extends AbstractModel implements  IdentityInterface, AuthorInterface
{
    const CACHE_TAG = 'uzhnu_about_author';

    protected function _construct()
    {
        $this->_init('Uzhnu\About\Model\ResourceModel\Author');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return $this->getData('id');
    }

    public function getName()
    {
        return $this->getData('name');
    }

    public function getEmail()
    {
        return $this->getData('email');
    }
}

