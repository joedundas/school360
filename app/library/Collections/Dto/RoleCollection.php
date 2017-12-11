<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/6/17
 * Time: 1:45 PM
 */
class RoleCollection extends AbstractDtoCollection
{

    public function __construct()
    {
    }

    public function getDefaultRoleDto() {
        $defaultRoleDto = false;
        foreach($this->items as $roleId=>$role) {
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