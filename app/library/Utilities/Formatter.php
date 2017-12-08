<?php

abstract class Formatter
{

    static $PersonNameCodes = array(
        'meta'=>array(
            'lowerCaseIndicatesFirstLetterOnly'=>true
        ),
        'codes'=>array(
            'P'=>'prefix', // name prefix
            'F'=>'first', // first name
            'f'=>'first', // first initial
            'M'=>'middle', // middle name
            'm'=>'middle',  // middle initial
            'L'=>'last', // last name
            'l'=>'last', // last initial
            'S'=>'suffix', // name suffix
        )
    );

    static $PhoneNumberCodes = array(
        'meta'=>array(
            'lowerCaseIndicatesFirstLetterOnly'=>false
        ),
        'codes'=>array(
            'T'=>'type',
            'A'=>'areaCode',
            'P'=>'prefix',
            'S'=>'suffix'
        )
    );
    static $AddressCodes = array(
        'meta'=>array(
            'lowerCaseIndicatesFirstLetterOnly'=>false
        ),
        'codes'=>array(
            'T'=>'type',
            'S'=>'street',
            'S2'=>'street2',
            'C'=>'city',
            'S'=>'state',
            'Z'=>'zip'
        )
    );

    // SpecialCodeIndicator is used in formatting input to indicate the next character(s) will
    //  be replaced with something.  In the method, the specialCodeIndicator will be temporarily
    //  changed to the TempFormat version (just in case the actual string has the speicalCodeIndicator
    //  as part of the intended string.
    static $SpecialCodeIndicator = '%';
    static $SpecialCodeIndicatorTempFormat = '%#%#%#';

    static public function roleType($roleType) {
       switch($roleType) {
           case 'staff': return 'Faculty/Staff'; break;
           case 'teacher': return 'Faculty/Teacher'; break;
           case 'parent': return 'Parent/Guardian'; break;
           case 'student': return 'Student'; break;
           case 'coach' : return 'Athletics/Coach'; break;
           default: return 'Unknown'; break;
       }
    }

    static public function address($addressArray,$formatThisString) {
        return self::makeReplacement($formatThisString,$addressArray,self::$AddressCodes);
    }
    static public function phoneNumber($phoneArray,$formatThisString) {
        return self::makeReplacement($formatThisString,$phoneArray,self::$PhoneNumberCodes);
    }

    static public function personName($nameArray,$formatThisString) {

        return self::makeReplacement($formatThisString,$nameArray,self::$PersonNameCodes);

    }

    static private function makeReplacement($formatThisString,$targetArray,$usingArray) {
        $formatThisString = self::setTemporaryPlaceHolder($formatThisString);

        $replaceArray = array();
        $replaceWithArray = array();
        foreach($usingArray['codes'] as $replaceThis=>$withThis) {

            if (!array_key_exists($withThis, $targetArray) && $targetArray[$withThis] !== 'NULL') {
                continue;
            }
            $replaceArray[] = '/' . self::$SpecialCodeIndicatorTempFormat . $replaceThis . '/';
            $component = trim($targetArray[$withThis]);
            if($component === '') {
                $replaceWithArray[] = '';
            }
            else if(ctype_lower($replaceThis) && $usingArray['meta']['lowerCaseIndicatesFirstLetterOnly']) {
                // just get first letter
                $replaceWithArray[] = $component[0];
            }
            else {
                $replaceWithArray[] = trim($component);
            }
        }

        $formatThisString =  self::replace($replaceArray,$replaceWithArray,$formatThisString);
        return self::unsetTemporaryPlaceHolder($formatThisString);
    }

    static private function replace($replaceArray,$replaceWithArray,$formatThisString) {
        return preg_replace(
            $replaceArray,
            $replaceWithArray,
            $formatThisString
        );
    }
    static private function setTemporaryPlaceHolder($formatThisString) {
        return preg_replace('/' . self::$SpecialCodeIndicator . '/',self::$SpecialCodeIndicatorTempFormat,$formatThisString);
    }
    static private function unsetTemporaryPlaceHolder($formatThisString) {
        return preg_replace("/" . self::$SpecialCodeIndicatorTempFormat . "/",self::$SpecialCodeIndicator,$formatThisString);
    }

}