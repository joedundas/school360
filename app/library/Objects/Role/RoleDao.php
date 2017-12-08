<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/8/17
 * Time: 10:38 AM
 */
class RoleDao
{

    private $dto;
    /**
     * RoleDao constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getDto()
    {
        return $this->dto;
    }

    /**
     * @param mixed $dto
     */
    public function setDto($dto)
    {
        $this->dto = $dto;
    }


}