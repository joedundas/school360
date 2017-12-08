<?php


class FeatureFlipDto
{
    private $schoolSpecificSet = false;
    private $loadedFeatures = false;
    private $repo;
    private $codes = array();
    private $schoolId = null;

    public function __construct()
    {


    }
    public function isFeatureEnabledForSchool($feature_code,$schoolDto) {

        if(!$this->featuresLoaded()) {
            throw new Exception('Tried to get feature flip without the codes hydrated');
        }
        if(!$this->isSchoolSpecific()) {
            throw new Exception('Tried to get school specific feature flip but school features not yet set');
        }
        if($this->getSchoolId() != $schoolDto->getSchoolId()) {
            throw new Exception('Cannot get feature flip enabled because school IDs do not match');
        }
        list($code,$subcode) = $this->splitIntoCodeAndSubcode($feature_code);
        $status = $this->getStatusForFeature($code,$subcode);

        return $status == 'on' ? true : false;
    }
    private function isSchoolSpecific() {
        return $this->schoolSpecificSet;
    }
    private function featuresLoaded() {
        return $this->loadedFeatures;
    }
    private function setLoadedFeaturesTo($bool) {
        $this->loadedFeatures = $bool;
    }
    private function setSchoolSpecificTo($bool) {
        $this->schoolSpecificSet = $bool;
    }
    private function getStatusForFeature($code,$subcode) {
        return $this->codes[$code][$subcode]['status'];
    }
    private function splitIntoCodeAndSubcode($feature_code) {
        $ff = explode(':',$feature_code);
        $code = $ff[0];
        $subcode = '';
        for($i=1; $i<count($ff); $i++) {
            $subcode = ':' . $ff[$i];
        }
        $subcode = ltrim($subcode,':');
        return array($code,$subcode);
    }
    public function hydrate_fromArray($array) {
        $this->reset();
        $this->setSchoolId($array['schoolId']);
        $this->setCodes($array['codes']);
        $this->setLoadedFeaturesTo(true);
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
        if(! $this->featuresLoaded()) {
            $this->loadFeatureCodes($schoolId);
        }
        else {
            $features = $this->repo->getFeatureFlipsForSchoolId($schoolId);

            foreach ($features as $idx => $feature) {
                $code = $feature['code'];
                $subcode = $feature['subcode'];
                $schoolId = $feature['schoolId'];
                if ($schoolId != 0) {
                    $this->codes[$code][$subcode]['setBy'] = 'SCHOOL_FEATURE_VALUE';
                    $this->codes[$code][$subcode]['status'] = $feature['status'];
                } elseif ($this->codes[$code][$subcode]['setBy'] === 'GLOBAL_FEATURE_DEFAULT') {
                    $this->codes[$code][$subcode]['setBy'] = 'ALLSCHOOL_FEATURE_DEFAULT';
                    $this->codes[$code][$subcode]['status'] = $feature['status'];
                }
            }
            $this->setSchoolId($schoolId);
        }
    }

    private function loadFeatureCodes($schoolId = false) {
        $this->reset();
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
        $this->setLoadedFeaturesTo(true);
        if($schoolId !== false) {
            $this->loadSchoolCodes($schoolId);
        }

    }
    private function reset() {
        $this->setSchoolId(null);
        $this->setCodes(array());
        $this->setLoadedFeaturesTo(false);
        $this->setSchoolSpecificTo(false);
    }
    private function setCodes($arr) {
        $this->codes = $arr;
    }
    private function getCodes() {
        return $this->codes;
    }
    public function setSchoolId($schoolId) {
        if($schoolId > 0) { $this->setSchoolSpecificTo(true); }
        else { $this->setSchoolSpecificTo(false); }
        $this->schoolId = $schoolId;
    }
    public function getSchoolId() {
        return $this->schoolId;
    }
}