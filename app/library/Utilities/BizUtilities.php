<?php

abstract class BizUtilities
{

    // DayOfWeekOrder must be in this order to match the normal Sunday=0, Saturday=6
    //   Other methods rely on this order.. change is at high risk
    static $dayOfWeekOrder = ['sun','mon','tue','wed','thu','fri','sat'];



    public function __construct() {

    }


    static public function inclusiveOperators($inclusive) {
        // returns an array of operators that are meant for selecting ranges.
        //   The inclusive indicates whether it should select end points or not.
        //  Input and output
        if($inclusive === true) { return array(">=","<="); }
        else if($inclusive === "left") { return array(">=","<");  }
        else if($inclusive === "right") { return array(">","<=");  }
        else if($inclusive === false) { return array(">","<");  }
        throw new Exception("inclusvieOperators input must be (true, left, right, or false");

    }
    static public function isSetAndNotBlank($key,$arr) {
        if(isset($arr[$key]) && $arr[$key] !== '' && $arr[$key] !== false) { return $arr[$key]; }
        return false;
    }

    static public function giveNthOrLastOfArray($arr,$n) {
        $n = $n-1;  // Set to array index (starting at 0)
        $arrSize = count($arr)-1;
        if($n >= $arrSize) { return $arr[count($arr)-1]; }
        return $arr[$n];
    }


    static public function ConvertDaysOfWeekToNumericArray($dows) {
        $order = self::$dayOfWeekOrder;
        $arr = array();
        for($i=0; $i<count($order); $i++) {
            if($dows[$order[$i]] === 'true') {
                $arr[] = $i;
            }
        }
        return $arr;
    }
    static public function ConvertDayOfWeekStringToNumber($str) {
        $order = self::$dayOfWeekOrder;
        for($i=0; $i<count($order); $i++) {
            if($order[$i] == $str) { return $i; }
        }
        return false;
    }
    static public function ConvertBinaryDaysOfWeekToObject($string) {
        $bins = str_split($string);
        $order = self::$dayOfWeekOrder;
        $obj = array();
        for($i=0; $i<count($order); $i++) {
                $obj[$order[$i]] = $bins[$i] == 1 ? 'true' : 'false';

        }
        return $obj;
    }

}