<?php
namespace  Uzhnu\Rest\Model;

use Uzhnu\Rest\Api\AuthorRepositoryInterface;
use  Uzhnu\Rest\Model\ResourceModel\Author as AuthorResource;
use  Uzhnu\Rest\Model\ResourceModel\Author\Collection as AuthorCollection;
use  Uzhnu\Rest\Model\ResourceModel\Author\CollectionFactory as AuthorCollectionFactory;
use Uzhnu\Rest\Model\AuthorFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;



class AuthorRepository implements AuthorRepositoryInterface
{
    protected  AuthorResource $authorResource;
    protected  AuthorFactory $authorFactory;
    protected  AuthorCollectionFactory $authorCollectionFactory;

    public function __construct(
        AuthorResource $authorResource,
        AuthorFactory $authorFactory,
        AuthorCollectionFactory $authorCollectionFactory

    ){
        $this->authorResource = $authorResource;
        $this->authorFactory = $authorFactory;
        $this->authorCollectionFactory = $authorCollectionFactory;
    }
    /**
     * @return AuthorInterface
     */
    public function get()
    {
        $authors = $this->authorFactory->create();
        return $authors->getCollection();
    }
}
