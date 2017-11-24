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
    protected $info = array(
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

    public function hydrate($schoolId) {

    }
    public function setName($name) {
        $this->info['name'] = $name;
    }
    public function setPrimaryAddress($street = '',$street2 = '',$city='',$state='',$zip='') {
         $this->setPrimaryStreetAddress($street,$street2);
         $this->setPrimaryCityAddress($city);
         $this->setPrimaryStateAddress($state);
         $this->setPrimaryZipCodeAddress($zip);
    }
    public function setPrimaryStreetAddress($street,$street2='') {
        $this->info['primary-address']['street'] = $street;
        $this->info['primary-address']['street2'] = $street2;
    }
    public function setPrimaryCityAddress($city) {
        $this->info['primary-address']['city'] = $city;
    }
    public function setPrimaryStateAddress($state) {
        $this->info['primary-address']['state'] = $state;
    }
    public function setPrimaryZipCodeAddress($zip) {
        $this->info['primary-address']['zip'] = $zip;
    }

}