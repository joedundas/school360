<?php


class FeatureCodeDto extends AbstractFeatureDto
{
    /*
     * IMPORTANT:  DTO's should only contain data and getters/setters for that data.  Any domain/business logic
     *   usually goes in the corresponding DAO for the DTO.
     */
    private $codeKey;
    private $code;
    private $subcode;


    private $default = false;
    private $title;
    private $description;
    private $memberCanSet;

    static $codeKeySeparator = ':';


    public function __construct()
    {
    }

    static public function getCodeKeySeparator() {
        return self::$codeKeySeparator;
    }

    public function getMemberCanSet() {
        return $this->memberCanSet;
    }
    public function setMemberCanSet($canSet = 'N') {
        $this->memberCanSet = $canSet;
    }
    public function getDefault()
    {
        return $this->default;
    }

    public function setDefault($default)
    {
        $this->default = $default;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
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

}