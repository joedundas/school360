<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/6/17
 * Time: 10:35 AM
 */
class RoleDto implements DtoInterface
{
    protected $roleId = false;
    protected $schoolId = false;
    protected $roleType = false;
    protected $canLogIn = 'N';
    protected $isDefault = 'N';

    protected $beginDate = false;
    protected $endDate = false;

    public $name = false;
    public $contactInfo = false;
    public $demographics = false;

    public function __construct()
    {
        $this->name = new PersonsNameValueObject();
        $this->demographics = new userDemographicsDTO();
        $this->contactInfo = new contactInformation();
    }

    public function getName() {
        return $this->name;
    }
    public function setIsDefault($vl) {
        $this->isDefault = $vl;
    }
    public function getIsDefault() {
        return $this->isDefault;
    }
    public function setBeginDate($date) {
        $this->beginDate = $date;
    }
    public function getBeginDate() {
        return $this->beginDate;
    }
    public function setEndDate($date) {
        $this->endDate = $date;
    }
    public function getEndDate() {
        return $this->endDate;
    }
    public function setCanLogIn($cl) {
        $this->canLogIn = $cl;
    }
    public function getCanLogIn() {
        return $this->canLogIn;
    }

    public function setRoleType($roleType) {
        $this->roleType = $roleType;
    }
    public function getRoleType() {
        return $this->roleType;
    }
    public function setSchoolId($schoolId) {
        $this->schoolId = $schoolId;
    }
    public function getSchoolId() {
        return $this->schoolId;
    }
    public function setRoleId($roleId) {
        $this->roleId = $roleId;
    }
    public function getRoleId()  {
        return $this->roleId;
    }
    public function getId() {
        return $this->roleId;
    }
}