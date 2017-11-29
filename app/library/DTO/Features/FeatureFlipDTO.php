<?php


class FeatureFlipDTO
{
    private $repo;
    private $codes = array();
    private $schoolId = null;

    public function __construct()
    {


    }
    public function hydrate_fromArray($array) {
        $this->reset();
        $this->setSchoolId($array['schoolId']);
        $this->setCodes($array['codes']);
    }

    public function hydrate_fromDB($schoolId,$repo = false) {
        $this->reset();
        if(!$repo) { $repo = new featureRepository(); }
        $this->repo = $repo;
        $this->loadFeatureCodes();
        $this->loadSchoolCodes($schoolId);
    }
    public function asArray() {
        return array(
            'schoolId'=>$this->getSchoolId(),
            'codes'=>$this->getCodes()
        );
    }
    private function loadSchoolCodes($schoolId) {
        $features = $this->repo->getFeatureFlipsForSchoolId($schoolId);
        foreach($features as $idx=>$feature) {
            $code = $feature['code'];
            $subcode = $feature['subcode'];
            $schoolId = $feature['schoolId'];
            if($schoolId != 0) {
                $this->codes[$code][$subcode]['setBy'] = 'SCHOOL_FEATURE_VALUE';
                $this->codes[$code][$subcode]['status'] = $feature['status'];
            }
            elseif($this->codes[$code][$subcode]['setBy'] === 'GLOBAL_FEATURE_DEFAULT') {
                $this->codes[$code][$subcode]['setBy'] = 'ALLSCHOOL_FEATURE_DEFAULT';
                $this->codes[$code][$subcode]['status'] = $feature['status'];
            }
        }
        $this->setSchoolId($schoolId);
    }

    private function loadFeatureCodes() {
        $features = $this->repo->getFeatureCodes();
        foreach($features as $idx=>$feature) {
            $code = $feature['code'];
            $subcode = $feature['subcode'];
            $this->codes[$code] = array();
            $this->codes[$code][$subcode] = array(
                'setBy'=>'GLOBAL_FEATURE_DEFAULT',
                'status'=>$feature['defaultStatus'],
                'title'=>$feature['title'],
                'description'=>$feature['description']
            );
        }

    }
    private function reset() {
        $this->setSchoolId(null);
        $this->setCodes(array());
    }
    private function setCodes($arr) {
        $this->codes = $arr;
    }
    private function getCodes() {
        return $this->codes;
    }
    public function setSchoolId($schoolId) {
        $this->schoolId = $schoolId;
    }
    public function getSchoolId() {
        return $this->schoolId;
    }
}