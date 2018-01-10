<?php

abstract class DependencyInjection
{



    public function __construct() {

    }




    static public function DataTransferPacket($param = '') {
        if($param == '' || $param == 'default') {
            return new DataTransferPacket();
        }
    }
}