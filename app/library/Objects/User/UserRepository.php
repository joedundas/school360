<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/20/17
 * Time: 12:43 PM
 */
class UserRepository extends AbstractRepository
{

    protected $query;


    public function getUserAndRoles($userId,$args = array()) {
        $onlyFetchActiveRoles = isset($args['onlyFetchActiveRoles']) ? $args['onlyFetchActiveRoles'] : true;
        if(!isset($args['selections'])) {
            $selections = array(
                'users.id as userId',
                'user_roles.id as roleId',
                'users.namePrefix as namePrefix',
                'users.firstName as firstName',
                'users.lastName as lastName',
                'users.nameSuffix as nameSuffix',
                'users.email as email',
                'users.canLogin as userCanLogin',
                'user_roles.role as userRole',
                'user_roles.schoolId as schoolId',
                'user_roles.canLogin as userRoleCanLogin',
                'user_roles.default_role as defaultRoleAtSchool',
                'user_roles.beginDate as roleBeginDate',
                'user_roles.endDate as roleEndDate'
            );
        }
        else {
            $selections = $args['selections'];
        }

        $this->query = DB::table('users');
        $this->query->leftJoin('user_roles','users.id','=','user_roles.userId');


        $this->query->select($selections);
        $this->query->where('users.id','=',$userId);
        if($onlyFetchActiveRoles && false) {
            //@TODO: make it work!!
            // $this->query->where();
        }
        return self::performQuery($this->query,'FETCH_ASSOC');
    }

    public function getUserDemographics($userId) {
        $this->query = DB::table('demographics');
        $this->query->select(
            array(
                'demographics.*'
            )
        );
        $this->query->where('demographics.userId','=',$userId);
        return self::performQuery($this->query,'FETCH_ASSOC');
    }
    public function getUsersContactInformation($userId) {
        $this->query = DB::table('contact_info');
        $this->query->select(
            array(
                'contact_info.userId as userId',
                'contact_info.userRoleId as roleId',
                'contact_info.isDefault as isDefault',
                'contact_info.contactType as type',
                'contact_info.entryType as entryType',
                'contact_info.contactInfo as info'
            )
        );
        $this->query->where('contact_info.userId','=',$userId);
        return self::performQuery($this->query,'FETCH_ASSOC');
    }
}