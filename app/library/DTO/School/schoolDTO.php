<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/23/17
 * Time: 10:10 AM
 */
class schoolDTO extends AbstractSchoolDTO
{


    public function __construct()
    {

        $this->mapper = new SchoolMapper();

        parent::__construct();
    }

    public function addSchoolTypeSpecificToArray($arr) {
        return $arr;
    }
}