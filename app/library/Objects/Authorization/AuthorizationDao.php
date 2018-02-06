<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/8/17
 * Time: 9:38 AM
 */
class AuthorizationDao
{
    private $authCodesCollection = false;
    private $roleAuthsCollection = false;
    private $roleId;

    public function __construct() {

    }

    public function setAuthCodesCollection(AuthorizationsCollection $collection) {
        $this->authCodesCollection = $collection;
    }
    public function setRoleAuthsCollection(RoleAuthorizationsCollection $collection) {
        $this->roleAuthsCollection = $collection;
        $this->setRoleId($collection->getRoleId());
    }
    public function getRoleId() {
        return $this->roleId;
    }
    public function setRoleId($roleId) {
        $this->roleId = $roleId;
    }
    public function isAuthorized($auth_code) {

        if($this->authCodesCollection === false) { // || $this->authCodesCollection->isAuthsLoaded() === false) {
            throw new Exception('Tried to check  an authorization in authorizations DAO without auth codes loaded');
        }
        if($this->roleAuthsCollection === false || $this->roleAuthsCollection->isRoleAuthorizationsLoaded() === false) {
            throw new Exception('Tried to check an authorization in authorizations DAO without role specific auths loaded');
        }

        $authCodeDto = $this->authCodesCollection->getById($auth_code);
        if($authCodeDto === false) {
            throw new Exception('Request for auth dto on an invalid auth code [' . $auth_code . ']');
        }
        $roleAuthDto = $this->roleAuthsCollection->getById($auth_code);

        if($roleAuthDto === false) {
            return $authCodeDto->getDefaultValue();
        }
        return $roleAuthDto->getValue();
    }
}