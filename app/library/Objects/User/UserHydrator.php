<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/7/17
 * Time: 1:33 PM
 */
class UserHydrator
{
    static public function hydrateUserAndRolesromDB(UserDto $dto,array $results) {
        $mappingToUserId = $dto->getUserId();
        foreach($results as $idx=>$result) {
            $userId = $result['userId'];
            if($userId !== $mappingToUserId) {
                throw new Exception('Mapping of Query Result to DTO where query result userID does not equal the DTO user ID');
            }
            if($idx == 0) {
                $dto->name->setPrefix($result['namePrefix']);
                $dto->name->setFirst($result['firstName']);
                $dto->name->setMiddle('');
                $dto->name->setLast($result['lastName']);
                $dto->name->setSuffix($result['nameSuffix']);
                $dto->setLoginEmail($result['email']);
            }
            $roleDto = new RoleDto();
            RoleHydrator::hydrateRoleFromDB($roleDto,$result);
            $dto->roles->add($roleDto);
        }
    }
    static public function hydrateUserSchoolsFromDB($dto) {
        $schools = schoolRepository::getSchoolIdsForUser($dto->getUserId());
        foreach($schools as $idx=>$school) {
            $dto->addSchool($school);
        }
    }
    static public function hydrateContactInfoResultsIntoUserDto(UserDto $dto,$results) {
        foreach($results as $idx=>$result) {
            $result['info'] = json_decode(base64_decode($result['info']),true);
            if($idx == 0 || $result['roleId'] == 0) {
                UserHydrator::putContactResultIntoContactInfo($dto->contactInfo,$result);
            }
            if($result['roleId'] !== 0) {
                $roleDto = $dto->roles->getRoleByRoleId($result['roleId']);
                UserHydrator::putContactResultIntoContactInfo($roleDto->contactInfo,$result);
            }
        }
    }
    static public function putContactResultIntoContactInfo($contactInfo,$result) {

        if($result['type'] === 'email') {
            $contactInfo->addEmail($result['info']['email'],$result['entryType'],$result['isDefault']);
        }
        else if($result['type'] === 'phone') {
            $contactInfo->addPhoneNumber($result['info']['phone'],$result['entryType'],$result['isDefault']);
        }
        else if($result['type'] === 'address') {
            $contactInfo->addAddress($result['info'],$result['entryType'],$result['isDefault']);
        }
        else {
            throw new Exception('Invalid contact item entry type in @hydrateDTOFromDB');
        }
    }
}