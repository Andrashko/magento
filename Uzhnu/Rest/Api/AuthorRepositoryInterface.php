<?php

namespace  Uzhnu\Rest\Api;

use Uzhnu\Rest\Api\Data\AuthorInterface;

/**
 * @package Uzhnu\Rest\Api
 * @api
 */

interface AuthorRepositoryInterface
{

    /**
     * @return AuthorInterface
     */
    public function get();

}
