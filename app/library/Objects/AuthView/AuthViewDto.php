<?php

class AuthViewDto implements DtoInterface
{

    /*
     * IMPORTANT:  DTO's should only contain data and getters/setters for that data.  Any domain/business logic
     *   usually goes in the corresponding DAO for the DTO.
     */
    private $repo;

    private $viewTag = false;
    private $requiredAuthorizations = array();
    private $requiredRoles = array();
    private $restrictedRoles = array();


    public function __construct()
    {

    }
    public function setRestrictedRoles(array $rr) {
        $this->restrictedRoles = $rr;
    }
    public function getRestrictedRoles() {
        return $this->restrictedRoles;
    }
    public function setRequiredAuthorizations(array $ra) {
        $this->requiredAuthorizations = $ra;
    }
    public function getRequiredAuthorizations() {
        return $this->requiredAuthorizations;
    }
    public function setRequiredRoles(array $rr) {
        $this->requiredRoles = $rr;
    }
    public function getRequiredRoles() {
        return $this->requiredRoles;
    }
    public function setViewTag($tag) {
        $this->viewTag = $tag;
    }
    public function getViewTag() {
        return $this->viewTag;
    }
    public function getId() {
        return $this->viewTag;
    }


}