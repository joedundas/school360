<?php

class Courses extends \Illuminate\Database\Eloquent\Model
{
    protected $table = "courses";
    protected $guarded = array('id');

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

}