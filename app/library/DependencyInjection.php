<?php

abstract class DependencyInjection
{



    public function __construct() {

    }




    static public function ApiResponse($param = '') {
        if($param == '' || $param == 'default') {
            return new AjaxResponseMessage();
        }
    }
}