<?php

class contactInformation
{

    protected $primaryPhoneIndex = false;
    protected $primaryEmailIndex = false;
    protected $primaryAddressIndex = false;

    protected $phoneNumbers = array();
    protected $emails = array();
    protected $addresses = array();

    public function __construct()
    {

    }

    public function addPhoneNumber($phone,$type,$isPrimary = 'N') {
        $phone = new PhoneValueObject($phone,$type);
        $index = count($this->phoneNumbers);
        $this->phoneNumbers[$index] = $phone;
        if($isPrimary === 'Y') {
            $this->setPrimaryPhoneIndex($index);
        }
    }

    public function addEmail($email,$type,$isPrimary = 'N') {
        $email = new EmailValueObject($type,$email);
        $index = count($this->emails);
        $this->emails[$index] = $email;
        if($isPrimary === 'Y') {
            $this->setPrimaryEmailIndex($index);
        }
    }
    public function addAddress($address,$type,$isPrimary = 'N') {

        $address = new AddressValueObject(
            isset($address['address1']) ? $address['address1'] : '',
            isset($address['address2']) ? $address['address2'] : '',
            isset($address['city']) ? $address['city'] : '',
            isset($address['state']) ? $address['state'] : '',
            isset($address['zip']) ? $address['zip'] : '',
            isset($address['country']) ? $address['country'] : 'US',
            $type
        );
        $index = count($this->addresses);
        $this->addresses[$index] = $address;
        if($isPrimary === 'Y') {
            $this->setPrimaryAddressIndex($index);
        }
    }

    public function setPrimaryPhoneIndex($idx) {
        $this->primaryPhoneIndex = $idx;
    }
    public function getPrimaryPhoneIndex() {
        return $this->primaryPhoneIndex;
    }
    public function setPrimaryAddressIndex($idx) {
        $this->primaryAddressIndex = $idx;
    }
    public function getPrimaryAddressIndex() {
        return $this->primaryAddressIndex;
    }
    public function setPrimaryEmailIndex($idx) {
        $this->primaryEmailIndex = $idx;
    }
    public function getPrimaryEmailIndex() {
        return $this->primaryEmailIndex;
    }
}