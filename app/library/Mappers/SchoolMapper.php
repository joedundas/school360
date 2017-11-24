<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/21/17
 * Time: 2:12 PM
 */
class SchoolMapper
{


    static public function mapQueryResultToDTO($queryResult,$dto) {

        self::setCommonSchoolInformationFromQueryToDTO($queryResult,$dto);

    }
    static public function setCommonSchoolInformationFromQueryToDTO($queryResult,$dto) {
        $dto->setName($queryResult->name);
        $dto->setSchoolId($queryResult->id);
        $dto->setPrimaryAddress(
            $queryResult->address,
            $queryResult->address2,
            $queryResult->city,
            $queryResult->state,
            $queryResult->zip
        );

    }
}