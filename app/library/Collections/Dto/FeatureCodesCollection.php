<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/6/17
 * Time: 1:45 PM
 */
class FeatureCodesCollection extends AbstractDtoCollection
{

    private $codesLoaded = false;


    public function __construct()
    {
    }


    public function reset() {
        $this->setCodesLoaded(false);
        parent::reset();
    }
    public function isCodesLoaded()
    {
        return $this->codesLoaded;
    }

    public function setCodesLoaded($codesLoaded)
    {
        $this->codesLoaded = $codesLoaded;
    }


}