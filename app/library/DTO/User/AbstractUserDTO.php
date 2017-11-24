<?php
class AbstractUserDTO implements UserDTOInterface
{
    protected $userTypeInformation;
    protected $userRepository;
    protected $userId = null;
    protected $mapper = null;
    protected $name = array(
        'prefix'=>'',
        'first'=>'',
        'middle'=>'',
        'last'=>'',
        'suffix'=>'',
        'nicknames'=>array(

        )
    );
    protected $contactInfo = array(
        'primary-email'=>'',
        'primary-phone'=>'',
    );

    protected $schools = array(

    );
    public function __construct()
    {

        $this->userRepository = UserFactory::createRepository($this->userType);
    }


    public function hydrate($userId) {
        $queryResult = $this->userRepository->getSingleUserByUserId($userId);

        $this->mapper->mapQueryResultToDTO(
            $queryResult[0],
            $this
        );

        $schools = schoolRepository::getSchoolIdsForUser($userId);
        //var_dump($schools);

        foreach($schools as $idx=>$school) {
            $this->schools[] = array(
                'schoolId'=>$school->schoolId,
                'name'=>$school->schoolName,
                'default'=>$school->default_school
            );
        }
    }
    public function getDefaultSchoolId() {
        for($i=0; $i<count($this->schools); $i++) {
            if($this->schools[$i]['default'] == 'Y') {
                return $this->schools[$i]['schoolId'];
            }
        }
        return false;
    }
    public function setUserId($userId) {
        $this->userid = $userId;
    }
    public function setFirstName($firstName) {
        $this->name['first'] = $firstName;
    }
    public function setLastName($lastName) {
        $this->name['last'] = $lastName;
    }
    public function setPrimaryEmail($email) {
        $this->contactInfo['primary-email'] = $email;
    }
    public function setPrimaryPhone($phone) {
        $this->contactInfo['primary-phone'] = $phone;
    }

    public function asArray() {
        $arr = array(
            'meta'=>$this->getUserInformationArray(),
            'name'=>$this->getNameArray(),
            'contact'=>$this->getContactInfoArray(),
            'schools'=>$this->getSchoolsArray()
        );
        return $this->addUserTypeSpecificInformationToAsArray($arr);
    }
    public function getSchoolsArray() {
        return $this->schools;
    }
    public function getUserInformationArray() {
        $userTypeInformation = $this->mapper->getUserTypeInformation($this->userType);
        return array(
            'userId'=>$this->userId,
            'userType'=>$this->userType,
            $userTypeInformation['id']=>$userTypeInformation['id']
        );
    }
    public function getNameArray() {
        return $this->name;
    }
    public function getContactInfoArray() {
        return $this->contactInfo;
    }
}