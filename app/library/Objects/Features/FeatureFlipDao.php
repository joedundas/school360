<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/8/17
 * Time: 9:41 AM
 */
class FeatureFlipDao
{

    private $dto;
    /**
     * FeatureFlipDao constructor.
     */
    public function __construct()
    {

    }

    public function getDto() {
        return $this->dto;
    }
    public function setDto($dto) {
        $this->dto = $dto;
    }
}