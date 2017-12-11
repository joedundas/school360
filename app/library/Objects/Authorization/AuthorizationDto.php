<?php

class AuthorizationDto implements DtoInterface
{

    /*
     * IMPORTANT:  DTO's should only contain data and getters/setters for that data.  Any domain/business logic
     *   usually goes in the corresponding DAO for the DTO.
     */


    public function __construct() {

        $this->authorizationRepository = new authorizationRepository();

    }

    public function getId() {
        //@TODO implement this.
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
            $passedRoleId = $userDto->getCurrentRoleId();
            $arrayRoleId = $array['roleId'];
            if($passedRoleId !== $arrayRoleId) {
                throw new Exception('Security Protection: Authorizations can not be verified for user role.');
            }
            $this->setUserDto($userDto);
            $this->userAuthorizations = $array['userAuth'];
            $this->markUserAuthorizationAs(true);
        }

    }

    protected $authCodeInformation = array();
    protected $userAuthorizations = array();
    protected $userAuthorizationsSet = false;

    protected $authorizationRepository;
    protected $userDto = false;
    protected $roleId = false;


    protected function createAuthorizationCodesArray($codes) {
        foreach($codes as $idx=>$code) {
            $this->authCodeInformation[$code['permissionCode']] = $code;
        }
    }

    public function asArray() {
        $arr = array(
            'codes'=>$this->authCodeInformation
        );
        if($this->userAuthorizationsSet) {
            $arr['roleId'] = $this->getRoleId();
            $arr['userAuth'] = $this->userAuthorizations;
        }
        return $arr;
    }
    public function setUserDto($userDto) {
        $this->userDto = $userDto;
    }
    public function getUserDto() {
        return $this->userDto;
    }
    protected function addUserSpecificAuthentication() {
        if($this->getUserDto() === false) {
            $this->throwNoUserDtoException('Cannot create user specific authorizations');
        }
        $results = $this->authorizationRepository->getUserSpecificAuthorizations($this->getUserRoleId(),$this->getCurrentSchoolId());
        foreach($results as $idx=>$result) {
            $this->userAuthorizations[$result['permissionCode']] = $result['permissionValue'];
        }
        $this->markUserAuthorizationAs(true);
    }
    protected function createUserRoleDefaultAuthenticationArray() {
        if($this->getUserDto() === false) {
            $this->throwNoUserDtoException('Cannot create User Role Default Authorization array');
        }
        $this->buildUserAuthorizationsSkeleton();
        $results = $this->authorizationRepository->getDefaultsAuthorizationsForUserRole($this->getUserRole());
        foreach($results as $idx=>$result) {
            $this->userAuthorizations[$result['permissionCode']] = $result['defaultValue'];
        }
    }
    protected function setAuthorizationOnCode($code,$value) {
        if(!array_key_exists($code,$this->userAuthorizations)) {
            throw new Exception('Invalid authorization code [' . $code . '], cannot set authorization code');
        }
        $this->userAuthorizations[$code] = $value;
    }
    public function getUserAuthorizationForCode($code) {
        if($this->userAuthorizationsSet === false) {
            throw new Exception('Cannot give a user authorization when authorizations specific to the user have not been set');
        }
        if(!array_key_exists($code,$this->userAuthorizations)) {
            throw new Exception('Invalid authorization code [' . $code . '] requested');
        }
        return $this->userAuthorizations[$code];
    }
    protected function buildUserAuthorizationsSkeleton() {
        $this->deleteUserAuthorizations();
        foreach($this->authCodeInformation as $code => $info) {
            $this->userAuthorizations[$code] = $info['defaultValue'];
        }
    }
    protected function deleteUserAuthorizations() {
        $this->userAuthorizations = array();
        $this->markUserAuthorizationAs(false);
    }
    protected function markUserAuthorizationAs($bool) {
        $this->userAuthorizationsSet = $bool;
    }
    public function isUserRoleSpecificAuthorizationSet() {
        return $this->userAuthorizationsSet;
    }
    public function getUserRoleId() {
        if($this->getUserDto() === false) {
            $this->throwNoUserDtoException('No access to @getUserRoleId');
        }
        $dto = $this->getUserDto();
        return $dto->getCurrentUserRoleId();
    }
    public function getCurrentSchoolId() {
        if($this->getUserDto() === false) {
            $this->throwNoUserDtoException('No access to @getCurrentSchoolId');
        }
        $dto = $this->getUserDto();
        return $dto->getCurrentSchoolId();
    }
    public function getUserRole() {
        if($this->getUserDto() === false) {
            $this->throwNoUserDtoException('No access to @getUserRole');
        }
        $dto = $this->getUserDto();
        return $dto->getCurrentUserRole();
    }

    protected function throwNoUserDtoException($msg) {
        throw new Exception('User DTO not set: ' . $msg);
    }

}