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

    public function __construct()
    {

    }
    public function getUsersShortName() {
        return $this->name['first'] . " " . $this->name['last'];
    }
    public function getCurrentSchoolName() {
        $currentSchoolName = 'No School Assoicated with User Session';
        for($i=0; $i<count($this->schools); $i++) {
            if($this->schools[$i]['schoolId'] === $this->getCurrentSchoolId()) {
                $currentSchoolName = $this->schools[$i]['name'];
                break;
            }
        }
        return $currentSchoolName;
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
        $queryResults = $this->userRepository->getSingleUserByUserId($userId);

        $this->mapper->mapQueryResultsToDTO(
            $userId,
            $queryResults,
            $this
        );

        $schools = schoolRepository::getSchoolIdsForUser($userId);

        foreach($schools as $idx=>$school) {
            $this->addSchool($school);
        }

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
    }
    public function getDefaultSchoolId($restrictToCanLogin = true) {
        // Returns the school that is marked as default.  If none are marked as
        //  default, it returns the first in the list.  Returns false if it
        //  cannot find a default.
        $defaultSchoolId = false;
        for($i=0; $i<count($this->schools); $i++) {

            // Continue if the current school is marked as can't login and the restriciton is set to true
            if($restrictToCanLogin && $this->schools[$i]['canLogIn'] === 'N') {
                continue;
            }

            if($this->schools[$i]['default'] == 'Y') {
                if($restrictToCanLogin && $this->getDefaultRoleIdForSchoolId($this->schools[$i]['schoolId']) === false) {
                    // Does not have a user role to log in to at this school...
                    continue;
                }
                return $this->schools[$i]['schoolId'];
            }
            elseif($defaultSchoolId === false) {
                $defaultSchoolId = $this->schools[$i]['schoolId'];
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
        $this->schools[] = array(
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
            'defaultAtSchool'=>isset($args['defaultRoleAtSchool']) ? $args['defaultRoleAtSchool'] : 'N'

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
            'rolesAtSchools'=>$this->getSchoolRoleIdsArray()
        );
        return $this->addUserTypeSpecificInformationToAsArray($arr);
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