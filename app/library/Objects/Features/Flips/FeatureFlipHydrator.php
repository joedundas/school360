<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/7/17
 * Time: 2:10 PM
 */
class FeatureFlipHydrator
{

    static public  function hydrateFeatureCodeDtoFromDB(FeatureCodeDto $dto,$result) {
        $dto->setCode($result['code']);
        $dto->setSubcode($result['subcode']);
        $dto->setDefault($result['defaultStatus']);
        $dto->setTitle($result['title']);
        $dto->setDescription($result['description']);
    }
    static public function hydrateFeatureFlipDtoFromFeatureFlipDB(FeatureFlipDto $dto,$result) {
        $dto->setSchoolId($result['schoolId']);
        $dto->setStatus($result['status']);
    }

}