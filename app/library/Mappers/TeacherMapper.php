<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/21/17
 * Time: 2:12 PM
 */
class ParentMapper extends UserMapper
{


    static public function mapQueryResultToDTO($queryResult,$dto) {
        self::setCommonDemographicsFromQueryToDTO($queryResult,$dto);
    }
}