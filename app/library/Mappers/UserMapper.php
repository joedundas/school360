<?php

class UserMapper
{

    public function mapQueryResultsToDTO($mapping_to_userId,$queryResults,$dto) {
        $dto->setUserId($mapping_to_userId);
        for($i=0; $i<count($queryResults); $i++) {
            $queryResult = $queryResults[$i];
            $userId = $queryResult['userId'];
            if($userId != $mapping_to_userId) {
                throw new Exception('Mapping of Query Result to DTO where query result userID does not equal the DTO user ID');
            }
            if($i==0) {
                $this->setCommonDemographicsFromQueryToDTO($queryResult,$dto);
            }
            $dto->addRole($queryResult);
        }
    }

    public function setCommonDemographicsFromQueryToDTO($queryResult,$dto) {
        $dto->setNamePrefix($queryResult['namePrefix']);
        $dto->setFirstName($queryResult['firstName']);
        $dto->setLastName($queryResult['lastName']);
        $dto->setNameSuffix($queryResult['nameSuffix']);
        $dto->setPrimaryEmail($queryResult['email']);
    }


//    static public function getUserRoleInformation($userRoleId,UserDTOInterface $userDto) {
//
//        $roles = $userDto->getUsersRoles();
//        $schools = $userDto->getUsersSchools();
//        $role = $roles[$userRoleId];
//
//        $roleType = 'staff';
//
//        return array(
//            'userRoleId'=>$userRoleId,
//            'roleType'=>$roleType,
//            'roleTitle'=>Formatter::roleType($roleType),
//            'name'=>$userDto->getUsersName('%P %F %m %D %S'),
//            'schoolId'=>1,
//            'schoolName'=>'This is the schools name',
//            'about'=>'This is where about will go',
//            'email'='email',
//            'phone'=>'phone',
//            'address'=>'address'
//        );
//    }

}