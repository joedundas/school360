<?php

class SchoolDto implements DtoInterface
{

    /*
     * IMPORTANT:  DTO's should only contain data and getters/setters for that data.  Any domain/business logic
     *   usually goes in the corresponding DAO for the DTO.
     */

    protected $name = null;
    protected $schoolId = null;
    public $address = null;


    public function __construct()
    {
        $this->address = new AddressValueObject();
    }

    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function setSchoolId($id) {
        $this->schoolId = $id;
    }
    public function getSchoolId() {
        return $this->schoolId;
    }
    public function getId() {
        return $this->schoolId;
    }

}