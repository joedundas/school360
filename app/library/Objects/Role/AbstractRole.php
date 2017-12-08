<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/2/17
 * Time: 6:23 AM
 */
class AbstractRole implements RoleInterface
{
    protected $schoolId;
    protected $roleType;
    protected $userId;

    protected $name = array(
        'prefix'=>'',
        'first'=>'',
        'middle'=>'',
        'last'=>'',
        'suffix'=>'',
        'nicknames'=>array()
    );
    protected $addresses;
    protected $phones;
    protected $emails;
}