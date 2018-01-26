<?php

class AuthorizationCodeDto implements DtoInterface
{

    /*
     * IMPORTANT:  DTO's should only contain data and getters/setters for that data.  Any domain/business logic
     *   usually goes in the corresponding DAO for the DTO.
     */

    private $category;
    private $subCategory;
    private $entryOrder;
    private $requires;
    private $defaultValue;
    private $title;
    private $code;
    private $description;

    public function __construct() {



    }
    public function getId() {
        return $this->getCode();
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getSubCategory()
    {
        return $this->subCategory;
    }

    public function setSubCategory($subCategory)
    {
        $this->subCategory = $subCategory;
    }

    public function getEntryOrder()
    {
        return $this->entryOrder;
    }

    public function setEntryOrder($entryOrder)
    {
        $this->entryOrder = $entryOrder;
    }

    /**
     * @return mixed
     */
    public function getRequires()
    {
        return $this->requires;
    }

    /**
     * @param mixed $requires
     */
    public function setRequires($requires)
    {
        $this->requires = $requires;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param mixed $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }




}