<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/26/17
 * Time: 7:06 AM
 */
class userDTO extends AbstractUserDTO
{
    public function __construct()
    {
        $this->userRepository = new userRepository();
        $this->mapper = new UserMapper();
        parent::__construct();
    }
    public function addUserTypeSpecificInformationToAsArray($arr) {
        // For future use, if we ever have different DTO for different user types, we can
        //   add different information to asArray from here.   For now, we will just
        //   return the array that it is passed.
        return $arr;
    }
}