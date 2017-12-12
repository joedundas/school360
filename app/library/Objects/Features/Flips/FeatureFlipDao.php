<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/8/17
 * Time: 9:41 AM
 */
class FeatureFlipDao
{

    private $schoolId = false;
    private $featureFlipsCollection = false;
    private $featureCodesCollection = false;

    public function __construct()
    {

    }
    public function setFeatureFlipsCollection(FeatureFlipsCollection $collection) {
        $this->featureFlipsCollection = $collection;
        $this->schoolId = $collection->getSchoolId();
    }
    public function setFeatureCodesCollection(FeatureCodesCollection $collection) {
        $this->featureCodesCollection = $collection;

    }
    public function setSchoolId($schoolId) {
        $this->schoolId = $schoolId;
    }
    public function getSchoolId() {
        return $this->schoolId;
    }
    public function getFeatureFlipStatus($feature_code) {
            return $this->getFeatureFlipStatusForSchool($this->getSchoolId(),$feature_code);
    }
    public function getFeatureFlipStatusForSchool($schoolId,$feature_code) {

        if($this->featureCodesCollection === false || !$this->featureCodesCollection->isCodesLoaded()) {
            throw new Exception('Tried to check if feature enabled in feature flip DAO without feature codes loaded');
        }
        if($this->featureFlipsCollection === false || !$this->featureFlipsCollection->isSchoolFeatureFlipsLoaded()) {
            throw new Exception('Tried to check if feature enabled for school without school feature flip data loaded');
        }
        if($schoolId != $this->getSchoolId() || $this->featureFlipsCollection->getSchoolId() != $schoolId) {
            throw new Exception('Checking for feature flip for school ID that does not match the school ID associated with the collection loaded in the DAO');
        }
        $featureCodeDto = $this->featureCodesCollection->getById($feature_code);
        if($featureCodeDto === false) {
            throw new Exception('Request for feature flip on an invalid feature code [' . $feature_code . ']');
        }
        $featureFlipDto = $this->featureFlipsCollection->getById($feature_code);
        if($featureFlipDto === false) {
            return $featureCodeDto->getDefault();
        }
        return $featureFlipDto->getStatus();

    }









}