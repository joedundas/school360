<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/23/17
 * Time: 10:11 AM
 */
class AbstractSchoolDTO
{

    protected $schoolRepository;
    protected $mapper = null;

    protected $schoolId;
    protected $schoolName;
    protected $address = array(
        'street'=>'',
        'street2'=>'',
        'city'=>'',
        'state'=>'',
        'zip'=>''
    );
    protected $info = array(
        'schoolId'=>'',
        'name'=>'',
        'primary-address'=>array(
            'street'=>'',
            'street2'=>'',
            'city'=>'',
            'state'=>'',
            'zip'=>''
        )
    );

    public function __construct()
    {
        $this->schoolRepository = new schoolRepository();
    }

    public function asArray() {
        $arr = array(
            'schoolId'=>$this->getSchoolId(),
            'schoolName'=>$this->getName(),
            'address'=>$this->getPrimaryAddress()
        );
        return $this->addSchoolTypeSpecificToArray($arr);
    }
    public function hydrate_fromDB($schoolId) {
        $queryResult = $this->schoolRepository->getSingleSchoolById($schoolId);
        $this->mapper->mapQueryResultToDTO(
            $queryResult[0],
            $this
        );
    }
    public function hydrate_fromArray($array) {
        $this->setSchoolId($array['schoolId']);
        $this->setName($array['schoolName']);
        list($street,$street2,$city,$state,$zip) = $array['address'];
        $this->setPrimaryAddress($street,$street2,$city,$state,$zip);
    }
    public function setSchoolId($id) {
        $this->schoolId = $id;
    }
    public function getSchoolId() {
        return $this->schoolId;
    }
    public function setName($name) {
        $this->schoolName = $name;
    }
    public function getName() {
        return $this->schoolName;
    }
    public function getPrimaryAddress() {
        return array(
            $this->address['street'],
            $this->address['street2'],
            $this->address['city'],
            $this->address['state'],
            $this->address['zip']
        );
    }
    public function setPrimaryAddress($street = '',$street2 = '',$city='',$state='',$zip='') {
         $this->setPrimaryStreetAddress($street,$street2);
         $this->setPrimaryCityAddress($city);
         $this->setPrimaryStateAddress($state);
         $this->setPrimaryZipCodeAddress($zip);
    }
    public function setPrimaryStreetAddress($street,$street2='') {
        $this->address['street'] = $street;
        $this->address['street2'] = $street2;
    }
    public function setPrimaryCityAddress($city) {
        $this->address['city'] = $city;
    }
    public function setPrimaryStateAddress($state) {
        $this->address['state'] = $state;
    }
    public function setPrimaryZipCodeAddress($zip) {
        $this->address['zip'] = $zip;
    }

}