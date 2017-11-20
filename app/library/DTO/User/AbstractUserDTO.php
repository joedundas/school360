<?php
class AbstractUserDTO implements UserDTOInterface
{
    protected $name = array(
        'prefix'=>'',
        'first'=>'',
        'middle'=>'',
        'last'=>'',
        'suffix'=>'',
        'nicknames'=>array(

        )
    );
}