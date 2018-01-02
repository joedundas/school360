<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/21/17
 * Time: 2:12 PM
 */
class RouteMapper
{
    static public function getAjaxRouteClassAndMethodFromShortName($shortClass,$shortMethod) {
        $class = \Config::get('ajax-routes.' . $shortClass . '.class','');
        if($class === '') { throw new Exception('Ajax Call to class ' . $shortClass . ' not found in mapping tables'); }
        $method = \Config::get('ajax-routes.' . $shortClass . '.calls.' . $shortMethod . '.method','');
        if($method === '') { throw new Exception('Ajax call to class ' . $shortClass . ' and method ' . $shortMethod . ' not found'); }
        return array('class'=>$class,'method'=>$method);
    }

}