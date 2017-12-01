<?php
class AbstractUserDTO implements UserDTOInterface
{

    protected $loginSession = array(
        'currentSchoolId'=>false,
        'currentUserRoleId'=>false
    );
    protected $userRepository;



    protected $mapper = null;

    protected $currentSchoolId;
    protected $currentUserRoleId;
    protected $userId = null;
    protected $email;

    protected $name = array(
        'prefix'=>'',
        'first'=>'',
        'middle'=>'',
        'last'=>'',
        'suffix'=>'',
        'nicknames'=>array(

        )
    );
    protected $contactInfo = array();
    protected $schoolRoleIds = array();
    protected $schools = array(

    );
    protected $roles = array(

    );
    protected $demographics = array();
    protected $addresses = array();
    protected $emails = array();
    protected $phones = array();


    public function __construct()
    {

    }
    public function getUsersShortName() {
        return $this->name['first'] . " " . $this->name['last'];
    }
    public function getCurrentSchoolName() {
        return isset($this->schools[$this->getCurrentSchoolId()]) ? $this->schools[$this->getCurrentSchoolId()]['name'] : 'No School Assoicated with User Session';
    }
    public function getCurrentUserRole() {
        return $this->roles[$this->getCurrentUserRoleId()]['role'];
    }
    public function setCurrentSchoolId($schoolId) {
        $this->currentSchoolId = $schoolId;
    }
    public function getCurrentSchoolId() {
        return $this->currentSchoolId;
    }
    public function setCurrentUserRoleId($userRoleId) {
        $this->currentUserRoleId = $userRoleId;
    }
    public function getCurrentUserRoleId() {
        return $this->currentUserRoleId;
    }


    public function hydrate_fromDB($userId) {

        // Schools must come before user roles.  User roles will need
        //  to access school information in @addRole
        $schools = schoolRepository::getSchoolIdsForUser($userId);
        foreach($schools as $idx=>$school) {
            $this->addSchool($school);
        }

        $queryResults = $this->userRepository->getSingleUserByUserId($userId);

        $this->mapper->mapQueryResultsToDTO(
            $userId,
            $queryResults,
            $this
        );


        $queryResults = $this->userRepository->getUsersContactInformation($userId);

        foreach($queryResults as $idx=>$contactInfo) {
            $this->addContactInfoItem($contactInfo);
        }
    }

    public function addContactInfoItem($contactInfo) {
        $contactInfo['info'] = json_decode(base64_decode($contactInfo['info']),true);
        $type = $contactInfo['type'];
        if($type == 'email') {
            $this->addEmail($contactInfo['userRoleId'],$contactInfo['info']);
        }
        elseif($type == 'phone') {
            $this->addPhone($contactInfo['userRoleId'],$contactInfo['info']);
        }
        elseif($type == 'address') {
            $this->addAddress($contactInfo['userRoleId'],$contactInfo['info']);
        }
    }
    public function addToDemographics($userRoleId,$key,$value) {
        if(!array_key_exists($userRoleId,$this->demographics)) {
            $this->demographics[$userRoleId] = array();
        }
        $this->demographics[$userRoleId][$key] = $value;
    }
    public function addAddress($userRoleId,$address) {
        if(!array_key_exists($userRoleId,$this->addresses)) {
            $this->addresses[$userRoleId] = array();
        }
        $this->addresses[$userRoleId][] = $address;
    }
    public function addEmail($userRoleId,$email) {
        if(!array_key_exists($userRoleId,$this->emails)) {
            $this->emails[$userRoleId] = array();
        }
        $this->emails[$userRoleId][] = $email;
    }
    public function addPhone($userRoleId,$phone) {
        if(!array_key_exists($userRoleId,$this->phones)) {
            $this->phones[$userRoleId] = array();
        }
        $this->phones[$userRoleId][] = $phone;
    }
    public function getRoleByUserRoleId($userRoleId) {
        if(array_key_exists($userRoleId,$this->roles)) {
            return $this->roles[$userRoleId];
        }
        return false;
    }



    public function hydrate_fromArray($array) {
        $this->setCurrentSchoolId($array['currentSchoolId']);
        $this->setCurrentUserRoleId($array['currentUserRoleId']);
        $this->setUserId($array['userId']);
        $this->setPrimaryEmail($array['email']);
        $this->roles = $array['roles'];
        $this->schools = $array['schools'];
        $this->schoolRoleIds = $array['rolesAtSchools'];
        $this->name = $array['name'];
        $this->demographics = $array['demographics'];
        $this->addresses = $array['addresses'];
        $this->phones = $array['phones'];
        $this->emails = $array['emails'];
    }
    public function getDefaultSchoolId($restrictToCanLogin = true) {
        // Returns the school that is marked as default.  If none are marked as
        //  default, it returns the first in the list.  Returns false if it
        //  cannot find a default.
        $defaultSchoolId = false;
        foreach($this->schools as $schoolId=>$schoolInfo)
        for($i=0; $i<count($this->schools); $i++) {

            // Continue if the current school is marked as can't login and the restriciton is set to true
            if($restrictToCanLogin && $schoolInfo['canLogIn'] === 'N') {
                continue;
            }

            if($schoolInfo['default'] == 'Y') {
                if($restrictToCanLogin && $this->getDefaultRoleIdForSchoolId($schoolId) === false) {
                    // Does not have a user role to log in to at this school...
                    continue;
                }
                return $schoolId;
            }
            elseif($defaultSchoolId === false) {
                $defaultSchoolId = $schoolId;
            }
        }
        return $defaultSchoolId;
    }
    public function getDefaultRoleIdForSchoolId($schoolId,$restrictToCanLogin = true) {
        // Returns the default role given a school ID.  If non are marked as default for the
        //   school, then it will return the first in the list.  Returns false if none are found.
        $defaultUserRoleId = false;
        for($i=0; $i<count($this->schoolRoleIds[$schoolId]); $i++) {
            $userRoleId = $this->schoolRoleIds[$schoolId][$i];

            // Continue if the current role is marked as cannot log in and the restriciton is set to true
            if($restrictToCanLogin && $this->roles[$userRoleId]['canLogIn'] === 'N') {
                continue;
            }

            if($this->roles[$userRoleId]['defaultAtSchool'] === 'Y') {
                return $userRoleId;
            }
            elseif($defaultUserRoleId === false) {
                $defaultUserRoleId = $userRoleId;
            }
        }

        return $defaultUserRoleId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }
    public function getUserId() {
        return $this->userId;
    }

    public function setFirstName($firstName) {
        $this->name['first'] = $firstName;
    }
    public function setLastName($lastName) {
        $this->name['last'] = $lastName;
    }
    public function setNamePrefix($prefix) {
        $this->name['prefix'] = $prefix;
    }
    public function setNameSuffix($suffix) {
        $this->name['suffix'] = $suffix;
    }
    public function setPrimaryEmail($email) {
        $this->email = $email;
    }
    public function getPrimaryEmail() {
        return $this->email;
    }

    public function addSchool($school) {
        if(!isset($school['schoolId'])) {
            throw new Exception('School ID not given when trying to add school to user DTO');
        }
        $this->schools[$school['schoolId']] = array(
            'schoolId'=>$school['schoolId'],
            'userRoleId'=>$school['userRoleId'],
            'name'=>$school['schoolName'],
            'default'=>$school['default_school'],
            'canLogIn'=>$school['canLogIn']
        );

    }
    public function addRole($args) {

        if(!isset($args['userRoleId'])) {
            throw new Exception('No user role ID given when adding role to user DTO');
        }
        if(!isset($args['schoolId'])) {
            throw new Exception('No school ID given when adding role to user DTO');
        }
        if(!isset($args['userRole'])) {
            throw new Exception('No role code given when adding role to user DTO');
        }
        $this->addUserRoleIdToSchoolId($args['userRoleId'],$args['schoolId']);
        $this->roles[$args['userRoleId']] = array(
            'schoolId'=>$args['schoolId'],
            'role'=>$args['userRole'],
            'beginDate'=>$args['roleBeginDate'] != '' && $args['roleBeginDate'] != 'NULL' ? new \Carbon\Carbon($args['roleBeginDate']) : '',
            'endDate'=>$args['roleEndDate'] != '' && $args['roleEndDate'] != 'NULL' ? new \Carbon\Carbon($args['roleEndDate']) : '',
            'canLogIn'=>isset($args['userRoleCanLogin']) ? $args['userRoleCanLogin'] : 'N',
            'defaultAtSchool'=>isset($args['defaultRoleAtSchool']) ? $args['defaultRoleAtSchool'] : 'N',

        );

    }

    public function addUserRoleIdToSchoolId($userRoleId,$schoolId) {
        if(!array_key_exists($schoolId,$this->schoolRoleIds)) {
            $this->schoolRoleIds[$schoolId] = array();
        }
        $this->schoolRoleIds[$schoolId][] = $userRoleId;
    }
    public function asArray() {
        $arr = array(
            'currentSchoolId'=>$this->getCurrentSchoolId(),
            'currentUserRoleId'=>$this->getCurrentUserRoleId(),
            'userId'=>$this->getUserId(),
            'email'=>$this->getPrimaryemail(),

            'name'=>$this->getNameArray(),
            'roles'=>$this->getRolesArray(),
            'schools'=>$this->getSchoolsArray(),
            'rolesAtSchools'=>$this->getSchoolRoleIdsArray(),
            'demographics'=>$this->getDemographicsArray(),
            'addresses'=>$this->getAddressesArray(),
            'emails'=>$this->getEmailsArray(),
            'phones'=>$this->getPhonesArray()
        );
        return $this->addUserTypeSpecificInformationToAsArray($arr);
    }
    public function getDemographicsArray() {
        return $this->demographics;
    }
    public function getAddressesArray() {
        return $this->addresses;
    }
    public function getEmailsArray() {
        return $this->emails;
    }
    public function getPhonesArray() {
        return $this->phones;
    }
    public function getSchoolsArray() {
        return $this->schools;
    }


    public function getNameArray() {
        return $this->name;
    }
    public function getContactInfoArray() {
        return $this->contactInfo;
    }
    public function getRolesArray() {
        return $this->roles;
    }
    public function getSchoolRoleIdsArray() {
        return $this->schoolRoleIds;
    }
}