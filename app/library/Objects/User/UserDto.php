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
    }

//    public function getCurrentSchoolName() {
//        return isset($this->schools[$this->getCurrentSchoolId()]) ? $this->schools[$this->getCurrentSchoolId()]['name'] : 'No School Assoicated with User Session';
//    }
//    public function getCurrentUserRole() {
//        return $this->roles[$this->getCurrentUserRoleId()]['role'];
//    }



//    public function addDemographicItem($demographic) {
//
//        $userRoleId = $demographic['userRoleId'];
//        foreach($demographic as $key=>$value) {
//            if(preg_match('/^dem\-(.*)$/',$key)) {
//                $key = str_replace('dem-','',$key);
//                $this->addToDemographics($userRoleId,$key,$value);
//            }
//        }
//
//    }
//
//    public function getDemographicsItemForUserRole($userRoleId,$item) {
//        $demographics = $this->getDemographicsArray();
//
//        if(!array_key_exists($userRoleId,$demographics)) {
//            return $this->getDemographicsItemForUser($item);
//        }
//        return isset($demographics[$userRoleId][$item]) ? $demographics[$userRoleId][$item] : '';
//    }
//    public function getDemographicsItemForUser($item) {
//        $demographics = $this->getDemographicsArray();
//        return isset($demographics[0][$item]) ? $demographics[0][$item] : '';
//    }
//    public function addToDemographics($userRoleId,$key,$value) {
//        if(!array_key_exists($userRoleId,$this->demographics)) {
//            $this->demographics[$userRoleId] = array();
//        }
//        $this->demographics[$userRoleId][$key] = $value;
//    }
//
//    public function getRoleByUserRoleId($userRoleId) {
//        if(array_key_exists($userRoleId,$this->roles)) {
//            return $this->roles[$userRoleId];
//        }
//        return false;
//    }
//
//    public function getDefaultPhoneForUserRole($userRoleId) {
//
//    }
//    public function getDefaultEmailForUserRole($userRoleId) {
//        $emails = $this->getEmailsArray();
//        if(!array_key_exists($userRoleId,$emails)) {
//            return $this->getPrimaryEmail();
//        }
//
//        if(count($emails[$userRoleId]) == 0) {
//            return $this->getPrimaryEmail();
//        }
//
//        for($i=0; $i<count($emails[$userRoleId]); $i++) {
//            if($emails[$userRoleId][$i]['default'] === 'Y') {
//               return $emails[$userRoleId][$i]['email'];
//            }
//        }
//        return $this->getPrimaryEmail();
//
//    }
//
//
//
//
//
//
//
//
//
//
//    public function addSchool($school) {
//        if(!isset($school['schoolId'])) {
//            throw new Exception('School ID not given when trying to add school to user DTO');
//        }
//        $this->schools[$school['schoolId']] = array(
//            'schoolId'=>$school['schoolId'],
//            'userRoleId'=>$school['userRoleId'],
//            'name'=>$school['schoolName'],
//            'default'=>$school['default_school'],
//            'canLogIn'=>$school['canLogIn']
//        );
//
//    }
//
//
//    public function addUserRoleIdToSchoolId($userRoleId,$schoolId) {
//        if(!array_key_exists($schoolId,$this->schoolRoleIds)) {
//            $this->schoolRoleIds[$schoolId] = array();
//        }
//        $this->schoolRoleIds[$schoolId][] = $userRoleId;
//    }
//
//    public function getDemographicsArray() {
//        return $this->demographics;
//    }
//    public function getAddressesArray() {
//        return $this->addresses;
//    }
//    public function getEmailsArray() {
//        return $this->emails;
//    }
//    public function getPhonesArray() {
//        return $this->phones;
//    }
//    public function getSchoolsArray() {
//        return $this->schools;
//    }
//
//
//    public function getContactInfoArray() {
//        return $this->contactInfo;
//    }
//    public function getRolesArray() {
//        return $this->roles;
//    }
//    public function getSchoolRoleIdsArray() {
//        return $this->schoolRoleIds;
//    }
//
//
//
//
//
//
//
//    public function addContactInfoItem($contactInfo) {
//        $contactInfo['info'] = json_decode(base64_decode($contactInfo['info']),true);
//        //var_dump($contactInfo);
//        $userRoleId = $contactInfo['userRoleId'];
//        if($userRoleId == 0) {
//            $dto = $this;
//        }
//        else {
//            $dto = $this->roles->getRoleByUserRoleId($userRoleId);
//        }
//        $this->addContactToDTO($contactInfo,$dto->contactInfo);
//
//    }
//



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

