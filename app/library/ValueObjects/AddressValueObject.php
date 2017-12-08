<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/6/17
 * Time: 12:07 PM
 */
class AddressValueObject implements ValueObjectInterface
{
    protected $type = false;
    protected $street = false;
    protected $street2 = false;
    protected $city = false;
    protected $state = false;
    protected $zip = false;
    protected $country = false;

    public function __construct($street1,$street2,$city,$state,$zip,$country = 'US',$type)
    {
        $this->setType($type);
       $this->setStreet($street1);
       $this->setStreet2($street2);
       $this->setCity($city);
       $this->setState($state);
       $this->setZip($zip);
       $this->setCountry($country);
    }

    public function format($format) {
        return Formatter::address($this->asArray(),$format);
    }
    public function asArray() {
        return array(
            'type'=>$this->getType(),
            'street'=>$this->getStreet(),
            'street2'=>$this->getStreet2(),
            'city'=>$this->getCity(),
            'state'=>$this->getState(),
            'zip'=>$this->getZip(),
            'country'=>$this->getCountry()
        );
    }

    public function __toString()
    {
        return $this->format('[%T] %S %S1 %C, %S %Z');
    }

    public function getType($type) {
        return $this->type;
    }
    public function setType($type) {
        $this->type = $type;
    }
    /**
     * @return bool
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param bool $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return bool
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * @param bool $street2
     */
    public function setStreet2($street2)
    {
        $this->street2 = $street2;
    }

    /**
     * @return bool
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param bool $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return bool
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param bool $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return bool
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param bool $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return bool
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param bool $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }


}