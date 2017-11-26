<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/23/17
 * Time: 10:15 AM
 */
class AbstractSchoolRepository extends AbstractRepository
{
    protected $query;

    static public function getSchoolIdsForUser($userId,$includeSchoolNames = true) {
        $query = DB::table('user_school_mapper');

        if($includeSchoolNames) {
            // Join to the schools table...
            $query->leftJoin('schools', 'user_school_mapper.schoolId', '=', 'schools.id');
        }

        $selections = array(
            'user_school_mapper.schoolId as schoolId',
            'user_school_mapper.userRoleId as userRoleId',
            'user_school_mapper.default_school as default_school',
            'user_school_mapper.canLogIn as canLogIn'
        );

        if($includeSchoolNames) {
            // select school name from schools table
            $selections[] = 'schools.name as schoolName';
        }
        $query->select($selections);
        $query->where('user_school_mapper.userId','=',$userId);

        return self::performQuery($query,'FETCH_ASSOC');
    }
    static public function getUserIdsForSchool($schoolId) {
        $query = DB::table('user_school_mapper');
        $query->where('user_school_mapper.schoolId','=',$schoolId);
        return self::performQuery($query);
    }
}