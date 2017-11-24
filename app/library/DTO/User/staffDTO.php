<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/20/17
 * Time: 9:06 AM
 */
class staffDTO extends AbstractUserDTO
{
    protected $userType = 'staff';
    protected $staffId = null;
    public function __construct()
    {

        $this->mapper = new StaffMapper();
        parent::__construct();

    }
    public function addUserTypeSpecificInformationToAsArray($arr) {
        return $arr;
    }


}