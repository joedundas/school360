<?php


class FeatureFlipDto extends AbstractFeatureDto
{
    /*
     * IMPORTANT:  DTO's should only contain data and getters/setters for that data.  Any domain/business logic
     *   usually goes in the corresponding DAO for the DTO.
     */
    private $codeKey;
    private $code;
    private $subcode;
    private $status;
    private $schoolId = false;
    static $codeKeySeparator = ':';


    public function __construct()
    {
    }

    static public function getCodeKeySeparator() {
        return self::$codeKeySeparator;
    }




    public function getCodeKey()
    {
        return $this->codeKey;
    }
    public function getId()
    {
        return $this->getCodeKey();
    }

    private function setCodeKey($codeKey)
    {
        $this->codeKey = $codeKey;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
        $this->setCodeKey($this->getCode() . ":" . $this->getSubcode());
    }

    public function getSubcode()
    {
        return $this->subcode;
    }

    public function setSubcode($subcode)
    {
        $this->subcode = $subcode;
        $this->setCodeKey($this->getCode() . ":" . $this->getSubcode());
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setSchoolId($schoolId) {
        $this->schoolId = $schoolId;
    }
    public function getSchoolId() {
        return $this->schoolId;
    }
}