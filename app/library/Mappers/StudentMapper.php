<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/21/17
 * Time: 2:12 PM
 */
class StudentMapper extends UserMapper
{


    static public function mapQueryResultToDTO($queryResult,$dto) {
        self::setCommonDemographicsFromQueryToDTO($queryResult,$dto);
    }
}