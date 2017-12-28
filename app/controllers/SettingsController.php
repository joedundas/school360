<?php
/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/27/17
 * Time: 12:40 PM
 */

namespace Edu3Sixty;


class SettingsController
{
    static public function getStatus($setting,$userId,$schoolId,$roleId) {
        $setting = \Config::get('edu-settings.' . $setting);
        if($setting === null) {
            throw new \Exception('Invalid Edu Setting Key in SettingsController');
        }
        $status = $setting['default'];
        $order = $setting['order'];
        foreach($order as $idx=>$key) {
            if($key == 'user') { $ident = $userId; }
            if($key == 'school') { $ident=$schoolId; }
            if($key == 'role') { $ident = $roleId; }
            $valuesArray = $setting[$key];

            //$valuesArray = \Config::get('api-log.' . $key,array());
            if(array_key_exists($ident,$valuesArray)) {
                $status = $valuesArray[$ident];
            }
        }
        return $status;
    }

}