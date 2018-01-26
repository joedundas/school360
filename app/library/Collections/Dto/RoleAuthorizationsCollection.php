<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/6/17
 * Time: 1:45 PM
 */
class RoleAuthorizationsCollection extends AbstractDtoCollection
{

    private $roleAuthorizationsLoaded = false;
    private $roleId;
    public function __construct()
    {
    }


    public function reset() {

        $this->setRoleAuthorizationsLoaded(false);
        parent::reset();
    }

    public function setRoleId($roleId) {
        $this->roleId = $roleId;
    }
    public function getRoleId() {
        return $this->roleId;
    }
    public function isRoleAuthorizationsLoaded()
    {
        return $this->roleAuthorizationsLoaded;
    }
    public function setRoleAuthorizationsLoaded($roleAuthorizationsLoaded)
    {
        $this->roleAuthorizationsLoaded = $roleAuthorizationsLoaded;
    }




}