<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/6/17
 * Time: 10:47 AM
 */
class PhoneValueObject implements ValueObjectInterface
{


    protected $areaCode = false;
    protected $prefix = false;
    protected $suffix = false;
    protected $type = false;

    public function __construct($number,$type)
    {
        $this->setNumber($number);
        $this->setType($type);
    }

    public function __toString()
    {
        return trim($this->format('[%T] (%A) %P-%S'));
    }

    public function format($format) {
        return Formatter::phoneNumber($this->asArray(),$format);
    }
    public function asArray() {
        return array(
            'type'=>$this->getType(),
            'areaCode'=>$this->getAreaCode(),
            'prefix'=>$this->getPrefix(),
            'suffix'=>$this->getSuffix()
        );
    }

    public function getAreaCode() {
        return $this->areaCode;
    }
    public function getPrefix() {
       return $this->prefix;
    }
    public function getSuffix() {
        return $this->suffix;
    }
    private function setAreaCode($ac) {
        $this->areaCode = $ac;
    }
    private function setPrefix($pr) {
        $this->prefix = $pr;
    }
    private function setSuffix($sf) {
        $this->suffix = $sf;
    }

    /**
     * @param bool $number
     */
    public function setNumber($number)
    {
        $number = preg_replace('/[^0-9]/','',$number);
        if(strlen($number) != 10) {
            throw new Exception('Invalid phone number in value object, must be 10 characters long');
        }
        for($i=0; $i<count($number); $i++) {
            if(!is_integer($number[$i])) {
                throw new Exception('Invalid phone number in value object, all characters must be integers');
            }
        }
        $this->setAreaCode($number,0,3);
        $this->setPrefix($number,3,3);
        $this->setSuffix($number,6,4);
    }

    /**
     * @return bool
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param bool $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}