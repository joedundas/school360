<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/9/17
 * Time: 4:40 AM
 */
class SchoolHydrator
{

    static public function hydrateSchoolFromDB(SchoolDto $dto,$result) {
        $dto->setName($result['schoolName']);
        $dto->setSchoolId($result['schoolId']);

        $dto->address->setStreet($result['street1']);
        $dto->address->setStreet2($result['street2']);
        $dto->address->setCity($result['city']);
        $dto->address->setState($result['state']);
        $dto->address->setZip($result['zip']);

    }
}