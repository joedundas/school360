<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/23/17
 * Time: 10:16 AM
 */
class SchoolRepository extends AbstractRepository
{
    protected $query;

    public function __construct() {

    }



    static public function getSchoolIdsForUser($userId,$includeSchoolNames = true) {
        $query = DB::table('user_school_mapper');

        if($includeSchoolNames) {
            // Join to the schools table...
            $query->leftJoin('schools', 'user_school_mapper.schoolId', '=', 'schools.id');
        }

        $selections = array(
            'user_school_mapper.userId as userId',
            'user_school_mapper.schoolId as schoolId',
            'user_school_mapper.roleId as roleId',

        );

        if($includeSchoolNames) {
            // select school name from schools table
            $selections[] = 'schools.name as schoolName';
            $selections[] = 'schools.address as street1';
            $selections[] = 'schools.address2 as street2';
            $selections[] = 'schools.city as city';
            $selections[] = 'schools.state as state';
            $selections[] = 'schools.zip as zip';

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

    public function getSingleSchoolById($schoolId) {
        $this->query = DB::table('schools');
        $this->query->where('schools.id','=',$schoolId);
        return self::performQuery($this->query);
    }
}