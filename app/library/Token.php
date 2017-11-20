<?php

abstract class Token
{

    protected $token;
    protected $type = 'ABS';
    protected $length = 16;

    public function __construct() {
        $this->token = str_random($this->length);
    }

    public function getTokenValue() {
        return $this->type . "_" . $this->token;
    }

}