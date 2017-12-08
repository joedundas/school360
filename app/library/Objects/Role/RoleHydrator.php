<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/7/17
 * Time: 2:10 PM
 */
class RoleHydrator
{

    static public function hydrateRoleFromDB(RoleDto $dto,$result) {
        $dto->setRoleId($result['roleId']);
        $dto->setRoleType($result['userRole']);
        $dto->setSchoolId($result['schoolId']);
        $dto->setCanLogIn($result['userRoleCanLogin']);
        $dto->setIsDefault($result['defaultRoleAtSchool']);
        $dto->setBeginDate($result['roleBeginDate']);
        $dto->setEndDate($result['roleEndDate']);
    }
}