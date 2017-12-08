<?php
class UserDto
{

    protected $userId = null;
    protected $loginEmail = null;
    protected $currentRoleId = null;
    protected $currentSchoolId = null;

    public $name = null;
    public $contactInfo = null;
    public $demographics = null;

    public $schools = null;
    public $roles = null;





    public function __construct()
    {
        $this->name = new PersonsNameValueObject();
        $this->demographics = new userDemographicsDTO();
        $this->contactInfo = new contactInformation();
        $this->roles = new RoleCollection();
        $this->schools = new SchoolCollection();
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
        return $this->loginEmail;
    }
    public function setLoginEmail($email) {
        $this->loginEmail = $email;
    }

}

