<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/6/17
 * Time: 1:45 PM
 */
class FeatureFlipsCollection extends AbstractDtoCollection
{

    private $schoolFeatureFlipsLoaded = false;
    private $schoolId;
    public function __construct()
    {
    }


    public function reset() {

        $this->setSchoolFeatureFlipsLoaded(false);
        parent::reset();
    }

    public function setSchoolId($schoolId) {
        $this->schoolId = $schoolId;
    }
    public function getSchoolId() {
        return $this->schoolId;
    }
    public function isSchoolFeatureFlipsLoaded()
    {
        return $this->schoolFeatureFlipsLoaded;
    }
    public function setSchoolFeatureFlipsLoaded($schoolFeatureFlipsLoaded)
    {
        $this->schoolFeatureFlipsLoaded = $schoolFeatureFlipsLoaded;
    }




}