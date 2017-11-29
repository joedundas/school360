<?php



class AuthorizationController extends BaseController {

    protected $authoriztionDTO;

    public function __construct($authorizationDTO) {
        $this->authorizationDTO = $authorizationDTO;
    }


    public function setAuthorizationForUserRole($userRoleId) {

    }
//    public function setAuthorizationForUserIdAtSchoolIdAsUserType($userDTO,$schoolDTO) {
//        $this->authorizationDTO->setUserIdAtSchoolIdAsUserType($userDTO,$schoolDTO);
//    }

}
