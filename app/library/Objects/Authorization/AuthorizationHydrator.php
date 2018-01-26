<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/7/17
 * Time: 2:10 PM
 */
class AuthorizationHydrator
{

    static public  function hydrateAuthorizationDtoFromTypesDB(AuthorizationCodeDto $dto,$result) {

        $dto->setCategory($result['permissionCategory']);
        $dto->setSubCategory($result['permissionSubCategory']);
        $dto->setEntryOrder($result['entryOrder']);
        $req = $result['requires'];
        if(is_null($req) || $req === '') {
            $req = array();
        }
        else {
            $req = json_decode($req,true);
        }
        $dto->setRequires($req);
        $dto->setDefaultValue($result['defaultValue']);
        $dto->setTitle($result['title']);
        $dto->setCode($result['permissionCode']);
        $dto->setDescription($result['description']);

    }

    static public function hydrateAuthorizationRoleSpecificDtoFromDB(AuthorizationCodeRoleSpecificDto $dto,$result) {
        $dto->setCode($result['permissionCode']);
        $dto->setValue($result['permissionValue']);
        $dto->setRoleId($result['roleId']);
    }
}