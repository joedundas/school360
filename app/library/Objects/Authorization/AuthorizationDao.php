<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/8/17
 * Time: 9:38 AM
 */
class AuthorizationDao
{
    private $dto;

    public function __construct() {

    }

    public function getDto() {
        return $this->dto;
    }
    public function setDto($dto) {
        $this->dto = $dto;
    }
}