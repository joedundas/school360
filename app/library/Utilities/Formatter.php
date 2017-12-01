<?php

abstract class Formatter
{

    static $PersonNameCodes = array(
        'P'=>'prefix', // name prefix
        'F'=>'first', // first name
        'f'=>'first', // first initial
        'M'=>'middle', // middle name
        'm'=>'middle',  // middle initial
        'L'=>'last', // last name
        'l'=>'last', // last initial
        'S'=>'suffix', // name suffix
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

    static public function personName($nameArray,$formatThisString) {


        // Temporarily change
        $formatThisString = preg_replace('/' . self::$SpecialCodeIndicator . '/',self::$SpecialCodeIndicatorTempFormat,$formatThisString);
        $replaceArray = array();
        $replaceWithArray = array();

        foreach(self::$PersonNameCodes as $replaceThis=>$withThis) {

            if(!array_key_exists($withThis,$nameArray) && $nameArray[$withThis] !== 'NULL') {
                continue;
            }

            $replaceArray[] = '/' . self::$SpecialCodeIndicatorTempFormat . $replaceThis . '/';

            $nameComponent = trim($nameArray[$withThis]);
            if($nameComponent === '') {
                $replaceWithArray[] = '';
            }
            else if(ctype_lower($replaceThis)) {
                // just get first letter
                $replaceWithArray[] = $nameComponent[0]; //strtoupper(trim($nameArray[$withThis][0]));

            }
            else {
                $replaceWithArray[] = trim($nameComponent);
            }
        }

        $formatThisString = preg_replace(
            $replaceArray,
            $replaceWithArray,
            $formatThisString
        );
        $formatThisString = preg_replace("/" . self::$SpecialCodeIndicator . "/",'%',$formatThisString);
        return $formatThisString;
    }


}