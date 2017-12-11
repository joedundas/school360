<?php
class UserDto
{

    /*
     * IMPORTANT:  DTO's should only contain data and getters/setters for that data.  Any domain/business logic
     *   usually goes in the corresponding DAO for the DTO.
     */

    // Login information
    protected $userId = false;
    protected $loginEmail = null;
    protected $currentRoleId = null;
    protected $currentSchoolId = null;

    // About the user
    public $name = null;
    public $contactInfo = null;
    public $demographics = null;

    // Dto Collections
    public $schools = null;
    public $roles = null;
    public $authorizations = null;


    public function __construct()
    {
        $this->name = new PersonsNameValueObject();
        $this->demographics = new userDemographicsDTO();
        $this->contactInfo = new contactInformation();
        $this->roles = new RoleCollection();
        $this->schools = new SchoolCollection();
        $this->authorizations = new AuthorizationsCollection();
        $this->loginEmail = new EmailValueObject();
    }

    // Getters and Setters
    public function getName() {
        return $this->name;
    }
    public function setCurrentSchoolId($schoolId) {
        $this->currentSchoolId = $schoolId;
    }
    public function getCurrentSchoolId() {
        return $this->currentSchoolId;
    }
    public function setCurrentRoleId($roleId) {
        $this->currentRoleId = $roleId;
    }
    public function getCurrentRoleId() {
        return $this->currentRoleId;
    }
    public function setUserId($userId) {
        $this->userId = $userId;
    }
    public function getId() {
        return $this->userId;
    }
    public function getUserId() {
        return $this->userId;
    }
    public function getLoginEmail() {
        return $this->loginEmail->getEmail();
    }
    public function setLoginEmail($email) {
        $this->loginEmail->setEmail($email);
        $this->loginEmail->setType('login');
    }

}

