<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/23/17
 * Time: 10:16 AM
 */
class schoolRepository extends AbstractSchoolRepository
{

    public function __construct() {

    }

    public function getSingleSchoolById($schoolId) {
        $this->query = DB::table('schools');
        $this->query->where('schools.id','=',$schoolId);
        return self::performQuery($this->query);
    }
}