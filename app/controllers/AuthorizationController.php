<?php



class AuthorizationController extends BaseController {

    protected $authoriztionDTO;

    public function __construct() {
        $this->authorizationDTO = new AuthorizationDTO();
    }

    public function setAuthorizationForUserIdAtSchoolIdAsUserType($userDTO,$schoolDTO) {
        $this->authorizationDTO->setUserIdAtSchoolIdAsUserType($userDTO,$schoolDTO);
    }

}
