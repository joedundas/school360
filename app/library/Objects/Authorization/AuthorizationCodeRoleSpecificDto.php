<?php

class AuthorizationCodeRoleSpecificDto implements DtoInterface
{

    /*
     * IMPORTANT:  DTO's should only contain data and getters/setters for that data.  Any domain/business logic
     *   usually goes in the corresponding DAO for the DTO.
     */


    private $value;
    private $roleId;
    private $code;


    public function __construct() {



    }
    public function getId() {
        return $this->getCode();
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param mixed $roleId
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }





}