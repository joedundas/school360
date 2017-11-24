<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/20/17
 * Time: 9:06 AM
 */
class parentDTO extends AbstractUserDTO
{
    protected $userType = 'parent';
    public function __construct()
    {
        $this->mapper = new ParentMapper();
        parent::__construct();
    }
}