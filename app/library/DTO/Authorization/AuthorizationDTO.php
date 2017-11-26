<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/24/17
 * Time: 12:44 PM
 */
class AuthorizationDTO extends AbstractAuthorizationDTO
{



    public function __construct() {

        parent::__construct();
    }

    public function setUserIdAtSchoolIdAsUserType($userDTO,$schoolDTO) {
        $userId = $userDTO->getUserId();
        $userType = $userDTO->getUserType();
        $schoolId = $schoolDTO->getSchoolId();
        echo "USER ID IS : " . $userId . " with USER TYPE: " . $userType . " at SCHOOL ID: " . $schoolId . "\n";
    }

}