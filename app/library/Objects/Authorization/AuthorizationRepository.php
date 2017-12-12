<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/23/17
 * Time: 10:16 AM
 */
class AuthorizationRepository
{

    protected $query;

    public function getAuthorizationCodes() {
        $this->query = DB::table('authorization_types');
        $this->query->orderBy('entryOrder','asc');
        return self::performQuery($this->query,'FETCH_ASSOC');
    }

    public function getDefaultsAuthorizationsForUserRole($userRole) {
        $this->query = DB::table('authorization_role_defaults');
        $this->query->where('role','=',$userRole);
        return self::performQuery($this->query,'FETCH_ASSOC');
    }
    public function getUserSpecificAuthorizations($roleId,$schoolId) {


        if(!is_int($roleId) || !is_int($schoolId)) {
            throw new Exception('Invalid values given for authorization repository');
        }
        $this->query = DB::table('user_authorizations');
        $this->query->where('roleId','=',$roleId);
        $this->query->where('schoolId','=',$schoolId);
        return self::performQuery($this->query,'FETCH_ASSOC');
    }
}