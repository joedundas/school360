<?php

class AjaxResponseMessage
{
    protected $error = false;
    protected $globalErrors = array();
    protected $formErrors = array();
    protected $passback = array();
    protected $results = array();

    public function __construct()
    {

    }
    public function asArray() {
        return array(
            'error'=>$this->inError(),
            'messages'=>array(
                'form'=>$this->formErrors,
                'meta'=>$this->globalErrors
            ),
            'passback'=>$this->passback,
        );
    }
    public function toJson() {
        return json_encode( $this->asArray() );
    }
    public function inError() {
        return $this->error;
    }
    public function getPassbackAsArray() {
        return $this->passback;
    }
    public function getPassbackValue($key) {
        if(isset($this->passback[$key])) {
            return $this->passback[$key];
        }
        return false;
    }
    public function insertGlobalErrors($messages) {
        $this->globalErrors = $messages;
        $this->error = true;
        return $this;
    }
    public function insertFormErrors($messages) {
       $this->formErrors = $messages;
        $this->error = true;
        return $this;
    }

    public function addPassback(array $pb) {
        foreach($pb as $key=>$value) {
            $this->passback[$key] = $value;
        }
        return $this;
    }
    public function erasePassback(array $keys = array()) {
        if(count($keys) == 0) { $this->passback = array(); }
        else {
            foreach($keys as $idx=>$key) {
                unset($this->passback[$key]);
            }
        }
        return $this;
    }

}