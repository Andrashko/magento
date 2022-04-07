<?php

namespace  Uzhnu\Rest\Api\Data;

/**
 * @package Uzhnu\Rest\Api\Data
 * @api
 */

interface  AuthorInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email);

}
