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

        $this->authorizationRepository = new authorizationRepository();

        parent::__construct();
    }


    public function hydrate_fromDB($userDto) {
        $this->createAuthorizationCodesArray($this->authorizationRepository->getAuthorizationCodes());
        $this->setUserDto($userDto);
        $this->createUserRoleDefaultAuthenticationArray();

        $this->addUserSpecificAuthentication();
    }

    public function hydrate_fromArray($array,$userDto = false) {
        $this->authCodeInformation = $array['codes'];
        if($userDto !== false) {
            $passedUserRoleId = $userDto->getCurrentUserRoleId();
            $arrayUserRoleId = $array['userRoleId'];
            if($passedUserRoleId !== $arrayUserRoleId) {
                throw new Exception('Security Protection: Authorizations can not be verified for user role.');
            }
            $this->setUserDto($userDto);
            $this->userAuthorizations = $array['userAuth'];
            $this->markUserAuthorizationAs(true);
        }

    }


}