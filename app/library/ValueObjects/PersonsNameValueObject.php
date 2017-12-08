<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/2/17
 * Time: 6:29 AM
 */
class PersonsNameValueObject implements ValueObjectInterface
{
    protected $hasBeenSet = false;
    protected $prefix = '';
    protected $first = '';
    protected $middle = '';
    protected $last = '';
    protected $suffix = '';

    public function asArray() {
        return array(
            'prefix'=>$this->getPrefix(),
            'first'=>$this->getFirst(),
            'middle'=>$this->getMiddle(),
            'last'=>$this->getLast(),
            'suffix'=>$this->getSuffix()
        );
    }

    public function reset() {
        $this->setHasBeenSet(false);
        $this->setPrefix('');
        $this->setSuffix('');
        $this->setFirst('');
        $this->setLast('');
        $this->setMiddle('');
    }
    public function setFromNameArray($nameArray) {
        foreach($nameArray as $key=>$value) {

            $setter = 'set' . ucfirst(strtolower($key));

            if(!method_exists($this,$setter)) {
                throw new Exception('In PersonsNameValueObject@setFromArrayName, trying to set an unkown key');
            }
            $this->$setter($value);
        }
        $this->setHasBeenSet(true);
        return $this;
    }

    /**
     * @return string
     * Returns the full name of the person if the object is treated as a string in the code.
     */
    public function  __toString()
    {
        return $this->format('%S %F %M %L %P');
    }

    /**
     * @param $format
     * @return string
     *
     * $format is a string where the tags %S, %F, %M, %L, %P will be replaced with suffix, first, middle, last, and prefix
     *   of the persons name, respectively.  If you use lower case on the tag, it will give first letter (initial)
     *
     *   For example, $format = 'Hi there %F %m %L' on my name would result in 'Hi there Joe M Dundas'
     */
    public function format($format)
    {
        return Formatter::personName($this->asArray(),$format);
    }

    /**
     * @return string
     */
    public function getPrefix()
    {

        return $this->prefix;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->setHasBeenSet(true);
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * @param string $first
     */
    public function setFirst($first)
    {
        $this->setHasBeenSet(true);
        $this->first = $first;
    }

    /**
     * @return string
     */
    public function getMiddle()
    {
        return $this->middle;
    }

    /**
     * @param string $middle
     */
    public function setMiddle($middle)
    {
        $this->setHasBeenSet(true);
        $this->middle = $middle;
    }

    /**
     * @return string
     */
    public function getLast()
    {
        return $this->last;
    }

    /**
     * @param string $last
     */
    public function setLast($last)
    {
        $this->setHasBeenSet(true);
        $this->last = $last;
    }

    /**
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @param string $suffix
     */
    public function setSuffix($suffix)
    {
        $this->setHasBeenSet(true);
        $this->suffix = $suffix;
    }

    public function setHasBeenSet($bool) {
        $this->hasBeenSet = $bool;
    }
    public function hasBeenSet() {
        return $this->hasBeenSet;
    }
}