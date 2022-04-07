<?php

namespace  Uzhnu\Rest\Model;

use Uzhnu\Rest\Api\Data\AuthorInterface;
use Uzhnu\Rest\Model\ResourceModel\Author as AuthorResource;
use Magento\Framework\Model\AbstractModel;

class Author extends  AbstractModel implements  AuthorInterface
{
    protected function _construct() //@codingStandardsIgnoreLine
    {
        $this->_init(AuthorResource::class);
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->getData('author_id');
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->setData('author_id', $id);
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->setData('name', $name);
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->getData('email');
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email)
    {
        $this->setData('email', $email);
        return $this;
    }
}
