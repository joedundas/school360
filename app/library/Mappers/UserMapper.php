<?php

class UserMapper
{


    //  List of user types and associated data (e.g. database ids)
    static protected $userTypes = array(
        'teacher'=>array('id'=>'teacherId'),
        'student'=>array('id'=>'studentId'),
        'staff'=>array('id'=>'staffId'),
        'parent'=>array('id'=>'parentId')
    );

    static public function setCommonDemographicsFromQueryToDTO($queryResult,$dto) {

        $dto->setUserId($queryResult->userId);
        $dto->setFirstName($queryResult->firstName);
        $dto->setLastName($queryResult->lastName);
        $dto->setPrimaryEmail($queryResult->email);
    }

    static public function getUserTypeArrayFromAuthUserModel($userModel) {
        $userTypes = UserMapper::getUserTypeInformation();
        $userTypeIds = array();
        foreach($userTypes as $userType=>$userTypeInfo) {
            $userTypeIds[$userTypeInfo['id']] = $userModel[$userTypeInfo['id']];
        }
        return $userTypeIds;
    }

    static public function getUserTypeInformation($type = false) {
        if($type === false) {
            return self::$userTypes;
        } elseif (is_array($type))
        {
            $returnArray = array();
            foreach($type as $idx=>$thisType) {
                if(!isset(self::$userTypes[$thisType])) {
                    throw new Exception('Request for user type information of unknown type [' . $thisType . '] in UserMapper@getUserTypeInformation');
                }
                $returnArray[$thisType] = self::$userTypes[$thisType];
            }
            return $returnArray;
        } elseif(is_string($type))
        {
            if(!isset(self::$userTypes[$type])) {
                throw new Exception('Request for user type information of unknown type [' . $type . '] in UserMapper@getUserTypeInformation');
            }
            return self::$userTypes[$type];
        }
        throw new Exception('UserMapper@getUserTypeInformation was given an unknown input');
    }

    static public function getUserTypeBasedOnIdArray($idsArray) {
        $userTypes = self::$userTypes;
        $returnUserType = null;
        foreach($userTypes as $userType=>$userTypeInfo) {
            if(isset($idsArray[$userTypeInfo['id']]) && $idsArray[$userTypeInfo['id']] > 0) {
                $returnUserType = self::setUserTypeIfNotAlreadySet($returnUserType,$userType);
            }
        }
        if($returnUserType === null) {
            throw new Exception('Could not determine user type based on ids given in UserMapper@getUserTypeBAsedOnIdArray');
        }
        return $returnUserType;
    }

    static public function setUserTypeIfNotAlreadySet($userType,$setToUserType) {
        if($userType !== null) {
            throw new Exception('Setting user type to [' . $setToUserType . '] but it has already been set to [' . $userType . ']');
        }
        return $setToUserType;
    }
}