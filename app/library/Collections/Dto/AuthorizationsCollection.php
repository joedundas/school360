<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/6/17
 * Time: 1:45 PM
 */
class AuthorizationsCollection extends AbstractDtoCollection
{


    private $authsLoaded = false;


    public function __construct()
    {
    }


    public function reset() {
        $this->setAuthsLoaded(false);
        parent::reset();
    }
    public function isAuthsLoaded()
    {
        return $this->authsLoaded;
    }

    public function setAuthsLoaded($authsLoaded)
    {
        $this->authsLoaded = $authsLoaded;
    }




}