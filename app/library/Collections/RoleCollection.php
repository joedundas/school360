<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/6/17
 * Time: 1:45 PM
 */
class RoleCollection
{

    protected $roles = array();



    public function __construct()
    {
    }

    public function count() {
        return count($this->roles);
    }

    public function add(RoleDto $role) {
        $this->roles[$role->getRoleId()] = $role;
    }
    public function getRoleByRoleId($roleId) {
        return $this->roles[$roleId];
    }

    public function getDefaultRoleDto() {
        $defaultRoleDto = false;
        foreach($this->roles as $userRoleId=>$role) {
            if($role->getIsDefault() === 'Y' && $role->getCanLogIn() === 'Y') {
                return $role;
            }
            if($defaultRoleDto !== false && $role->getCanLogIn() === 'Y') {
                $defaultRoleDto = $role;
            }

        }
        return $defaultRoleDto;
    }



}