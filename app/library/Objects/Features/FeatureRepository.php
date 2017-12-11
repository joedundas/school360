<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/23/17
 * Time: 10:16 AM
 */
class FeatureRepository extends AbstractRepository
{

    public function __construct() {

    }

    static public function getFeatureCodes() {
        $query = DB::table('feature_codes');
        $query->select(array(
            'feature_codes.code as code',
            'feature_codes.subcode as subcode',
            'feature_codes.defaultStatus as defaultStatus',
            'feature_codes.title as title',
            'feature_codes.description as description'
        ));
        return self::performQuery($query,'FETCH_ASSOC');
    }
    static public function getFeatureFlipsForSchoolId($schoolId) {
        $query = DB::table('feature_flips');
        $query->select(
            array(
                'feature_flips.schoolId as schoolId',
                'feature_flips.code as code',
                'feature_flips.subcode as subcode',
                'feature_flips.status as status'
            )
        );
        $query->where('schoolId','=',$schoolId);
        $query->orWhere('schoolId','=',0);
        return self::performQuery($query,'FETCH_ASSOC');
    }
}