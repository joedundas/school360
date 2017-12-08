<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/6/17
 * Time: 11:53 AM
 */
class EmailValueObject implements ValueObjectInterface
{

    protected $type;
    protected $email;
    public function __construct($email = '',$type = '')
    {
        if($email != '') {
            $this->setEmail($email);
            $this->setType($type);
        }
    }

    public function setEmail($em) {
        $this->email = $em;
    }
    public function setType($type) {
        $this->type = $type;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getType() {
        return $this->type;
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return trim($this->getEmail());
    }
}